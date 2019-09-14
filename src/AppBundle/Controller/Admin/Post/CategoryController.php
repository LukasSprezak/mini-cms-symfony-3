<?php

namespace AppBundle\Controller\Admin\Post;

use AppBundle\Entity\Post\Category;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\{
    Post\AbstractPostType
};
use Symfony\Component\HttpFoundation\{
    RedirectResponse,
    Request,
    Response
};

/**
 * @Route("/admin/post")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/category/{page}", name="category", defaults={"page"=1})
     * @param $page
     * @return Response
     */
    public function categoryAction(string $page)
    {
        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);
        $query = $categoryRepository
            ->createListQueryBuilder();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $page
        );

        return $this->render('admin/category/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route(
     *      "/cat/create/{id}",
     *      name="category_create",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     * @param Request $Request
     * @param Category|null $category
     * @return RedirectResponse|Response
     */
    public function formAction(Request $Request, Category $category = NULL)
    {

        if(NULL === $category){
            $category = new Category();
            $newCategory = TRUE;
        }

        $form = $this->createForm(AbstractPostType::class, $category);

        $form->handleRequest($Request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            $message = (isset($newCategory))
                ? 'Poprawnie dodano nową kategorię!'
                : 'Poprawiono dane kategorii';

            $this->addFlash("success", $message);

            return $this->redirect($this->generateUrl('category_create', [
                'id' => $category->getId()
            ]));
        }

        return $this->render('admin/category/form.html.twig', [
            'form' => $form->createView(),
            'category' => $category
        ]);
    }

    /**
     * @Route("/category/delete/{id}", name="category_delete")
     * @param Category $category
     * @return RedirectResponse
     */
    public function deleteAction(Category $category)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();
        $this->addFlash("error", "category.delete_success");

        return $this->redirectToRoute("category");
    }
}