<?php

namespace AppBundle\Controller\Admin\Post;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\{
    Entity\Post\Tag,
    Form\Post\AbstractPostType
};
use Symfony\Component\{
    HttpFoundation\RedirectResponse,
    HttpFoundation\Request,
    HttpFoundation\Response,
    Routing\Annotation\Route
};

/**
 * @Route("/admin/post")
 */
class TagsController extends Controller
{
    /**
     * @Route("/tag/{page}", name="tag", methods={"GET"}, requirements={"page"="\d+"}, defaults={"page"=1})
     * @param Request $Request
     * @param $page
     * @return Response
     */
    public function tagAction(Request $Request, string $page)
    {
        $tagRepository = $this->getDoctrine()->getRepository(Tag::class);
        $query = $tagRepository
            ->createListQueryBuilder();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $page
        );

        return $this->render("admin/tags/tags.html.twig", [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/post/tag/create/{id}", methods={"GET", "POST"}, name="tag_create", requirements={"id"="\d+"}, defaults={"id"=NULL}
     * )
     * @param Request $Request
     * @param Tag|null $tag
     * @return RedirectResponse|Response
     */
    public function formAction(Request $Request, Tag $tag = NULL)
    {
        if (NULL === $tag) {
            $tag = new Tag();
            $newTag = TRUE;
        }

        $form = $this->createForm(AbstractPostType::class, $tag);
        $form->handleRequest($Request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tag);
            $entityManager->flush();

            $flashMessage = (isset($newTag))
                ? 'Poprawnie dodano nowy tag'
                : 'Poprawiono tag';
            $this->addFlash("success", $flashMessage);

            return $this->redirect($this->generateUrl('tag_create', [
                'id' => $tag->getId()
            ]));

        }
        return $this->render("admin/tags/form.html.twig", [
            'form' => $form->createView(),
            'tag' => $tag
        ]);
    }

    /**
     * @Route("/tag/delete/{id}", name="tag_delete", requirements={"id"="\d+"})
     * @param $id
     * @return RedirectResponse
     */
    public function deleteAction(int $id)
    {
        $tag = $this->getDoctrine()->getRepository(Tag::class)
            ->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($tag);
        $entityManager->flush();
        $this->addFlash('success', "post.tag_success");

        return $this->redirect($this->generateUrl('tag'));
    }
}