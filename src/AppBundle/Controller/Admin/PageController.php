<?php

namespace AppBundle\Controller\Admin;

use Knp\Component\Pager\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\{
    Form\PageType,
    Entity\Page
};
use Symfony\Component\{
    HttpFoundation\Response,
    HttpFoundation\Request,
    HttpFoundation\RedirectResponse,
    Form\Extension\Core\Type\SubmitType,
    Routing\Annotation\Route
};

/**
 * @Route("/admin/page")
 */
class PageController extends Controller
{
    /**
     * @Route("/", name="page_index", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function pageAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->getRepository(Page::class)
            ->findAll();

        /**
         * @var $paginator Paginator
         */
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->render("admin/page/index.html.twig", [
            'pages_list' => $pagination
        ]);
    }

    /**
     * @Route("/search", name="page_search", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function searchAction(Request $request)
    {
        $queryParameters = [
            'searchPageByTitle' => htmlspecialchars($request->query->get('searchPageByTitle'))
        ];

        $pageRepository = $this->getDoctrine()->getRepository(Page::class);
        $query = $pageRepository
            ->getSearchPageByTitle($queryParameters);

        /**
         * @var $paginator Paginator
         */
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->render("admin/page/index.html.twig", [
            'pages_list' => $pagination,
            'queryParameters' => $queryParameters,
        ]);
    }

    /**
     * @Route("/create", name="page_create", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request)
    {
        $page = new Page();

        $form = $this->createForm(PageType::class, $page);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($page);
            $entityManager->flush();

            $this->addFlash("success", "page.add_success");
            $this->addFlash("error", "page.add_error");

            return $this->redirectToRoute('page_details', [
                "id" => $page->getId()
            ]);
        }

        return $this->render("admin/page/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="page_details", methods={"GET"})
     * @param Page $page
     * @return Response
     */
    public function detailsAction(Page $page)
    {
        $deleteForm = $this->createFormBuilder()
            ->setAction($this->generateUrl("page_delete", ["id" => $page->getId()]))
            ->setMethod(Request::METHOD_DELETE)
            ->add("submit", SubmitType::class, ["label" => "menu.delete"])
            ->getForm();

        if(null === $page){
            throw $this->createNotFoundException('Strona nie został odnaleziona.');
        }

        return $this->render('admin/page/show.html.twig', [
            'page' => $page,
            'deleteForm' => $deleteForm->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="page_edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Page $page
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Page $page)
    {
        $form = $this->createForm(PageType::class, $page);

        if ($request->isMethod("POST"))
        {
            $form->handleRequest($request);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($page);
            $entityManager->flush();

            $this->addFlash("success", "page.updated_success");

            return $this->redirectToRoute("page_details", [
                "id" => $page->getId()
            ]);
        }

        return $this->render("admin/page/edit.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="page_delete", methods={"DELETE"})
     * @param Request $request
     * @param Page $page
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Page $page)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($page);
        $entityManager->flush();
        $this->addFlash("error", "page.delete_success");

        return $this->redirectToRoute("page_index");
    }
}