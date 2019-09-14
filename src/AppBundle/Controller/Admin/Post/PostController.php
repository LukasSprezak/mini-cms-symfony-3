<?php

namespace AppBundle\Controller\Admin\Post;

use Knp\Component\Pager\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\{
    Entity\Post\Category,
    Entity\Post\Post,
    Form\Post\PostType
};
use Symfony\Component\HttpFoundation\{
    RedirectResponse,
    Request,
    Response
};
use Symfony\Component\{
    Form\Extension\Core\Type\SubmitType,
    Routing\Annotation\Route
};

/**
 * @Route("/admin/post")
 */
class PostController extends Controller
{
    /**
     * @Route("/", name="post_index", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function postAction(Request $request)
    {
        $queryParameters = [
            'categorySelectedId' => $request->query->get('categorySelectedId')
        ];

        $postRepository = $this->getDoctrine()->getRepository(Post::class);
        $query = $postRepository
            ->createListQueryBuilder($queryParameters);

        /**
         * @var $paginator Paginator
         */
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query
        );

        $categoryList = $this->getDoctrine()->getRepository(Category::class)
            ->getCategoryToArray();

        return $this->render("admin/post/index.html.twig", [
            'posts_list' => $pagination,
            'queryParams' => $queryParameters,
            'categoriesList' => $categoryList,
        ]);
    }

    /**
     * @Route("/create", name="post_create", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function createAction(Request $request)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $post
                ->setCreateDate(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash("success", "post.add_success");

            return $this->redirectToRoute('post_details', [
                "id" => $post->getId()
            ]);
        }

        return $this->render("admin/post/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="post_details", methods={"GET"})
     * @param Post $post
     * @return Response
     */
    public function detailsAction(Post $post)
    {
        $deleteForm = $this->createFormBuilder()
            ->setAction($this->generateUrl("post_delete", ["id" => $post->getId()]))
            ->setMethod(Request::METHOD_DELETE)
            ->add("submit", SubmitType::class, ["label" => "menu.delete"])
            ->getForm();

        return $this->render('admin/post/show.html.twig', [
            'post' => $post,
            'deleteForm' => $deleteForm->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="post_edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Post $post
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function editAction(Request $request, Post $post)
    {
        $form = $this->createForm(PostType::class, $post);

        if ($request->isMethod("post"))
        {
            $form->handleRequest($request);
            $post
                ->setUpdateDate(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash("success", "post.update_success");

            return $this->redirectToRoute("post_details", [
                "id" => $post->getId()
            ]);
        }

        return $this->render("admin/post/edit.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="post_delete", methods={"DELETE"})
     * @param Post $post
     * @return RedirectResponse
     */
    public function deleteAction(Post $post)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($post);
        $entityManager->flush();
        $this->addFlash("error", "post.delete_success");

        return $this->redirectToRoute("post_index");
    }
}