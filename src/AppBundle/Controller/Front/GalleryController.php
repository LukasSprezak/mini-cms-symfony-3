<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Gallery\Gallery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\{
    HttpFoundation\Response,
    Routing\Annotation\Route
};

class GalleryController extends Controller
{
    /**
     * @Route("/images/", name="galleries")
     *
     */
    public function clientAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $galleries = $entityManager->getRepository(Gallery::class)
            ->findAll();

        return $this->render("Front/client.html.twig", [
            'galleries' => $galleries
        ]);
    }

    /**
     * @Route("/images/{fullname}", name="gallery_page")
     * @param Gallery $folder
     * @return Response
     */
    public function details(Gallery $folder)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $folders = $entityManager
            ->getRepository(Gallery::class)
            ->viewGalleryImages($folder);

        return $this->render('Front/gallery.html.twig', [
            'folders' => $folders,
        ]);
    }
}