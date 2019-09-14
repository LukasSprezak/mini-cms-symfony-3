<?php

namespace AppBundle\Controller\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\{
    Entity\Gallery\Gallery,
    Form\Gallery\GalleryType
};
use Symfony\{
    Component\Routing\Annotation\Route,
    Bundle\FrameworkBundle\Controller\Controller,
    Component\HttpFoundation\RedirectResponse,
    Component\HttpFoundation\Request,
    Component\HttpFoundation\Response
};

/**
 * @Route("/admin/gallery")
 */
class GalleryController extends Controller
{
    /**
     * @Route("/", name="gallery", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function galleryAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $galleries = $entityManager->getRepository(Gallery::class)
            ->findAll();

        return $this->render("admin/gallery/index.html.twig", [
            "galleries" => $galleries
        ]);
    }

    /**
     * @Route("/create", name="gallery_create", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $gallery = new Gallery();

        $form = $this->createForm(GalleryType::class, $gallery);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gallery);
            $entityManager->flush();

            $this->addFlash("success", "gallery.add_success");

            return $this->redirectToRoute('gallery', [
                "id" => $gallery->getId()
            ]);
        }

        return $this->render("Admin/gallery/create.html.twig", [
            "form" => $form->createView()
        ]);
    }


    /**
     * @Route("/{fullname}", name="gallery_details", methods={"GET"})
     * @param Gallery $gallery
     * @return Response
     */
    public function detailsAction(Gallery $gallery)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $galleries = $entityManager
            ->getRepository(Gallery::class)
            ->viewGalleryImages($gallery);

        return $this->render(
            'Admin/gallery/show.html.twig', [
                'galleries' => $galleries,
            ]);
    }


    /**
     * @Route("/edit/{id}", name="gallery_edit", methods={"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function indexAction(Request $request, int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        /**
         * @var $gallery Gallery
         */
        $gallery = $entityManager->getRepository(Gallery::class)
            ->findOneBy(['id' => $id]);

        $orignalItem = new ArrayCollection();
        foreach ($gallery->getItem() as $item) {
            $orignalItem->add($item);
        }

        $form = $this->createForm(GalleryType::class, $gallery);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            foreach ($orignalItem as $item) {
                if ($gallery->getItem()->contains($item) === false) {
                    $entityManager->remove($item);
                }
            }
            $entityManager->persist($gallery);
            $entityManager->flush();
        }

        return $this->render('admin/gallery/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="gallery_delete")
     * @param $id
     * @return RedirectResponse
     */
    public function deleteAction(int $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $gallery = $entityManager->getRepository(Gallery::class)
            ->find($id);

        $entityManager->remove($gallery);
        $entityManager->flush();
        $this->addFlash("error", "gallery.delete_success");

        return $this->redirectToRoute('gallery');
    }

}
