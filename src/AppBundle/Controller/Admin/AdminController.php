<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\{
    Gallery\Gallery,
    Page,
    Post\Post,
    User
};

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $PageRepository = $entityManager->getRepository(Page::class);
        $PostRepository = $entityManager->getRepository(Post::class);
        $UserRepository = $entityManager->getRepository(User::class);
        $GalleryRepository = $entityManager->getRepository(Gallery::class);

        return $this->render("admin/index.html.twig", [
            'countPages' => $PageRepository->countAmountPages(),
            'countPosts' => $PostRepository->countAmountPosts(),
            'countUsers' => $UserRepository->countAmountUsers(),
            'countGalleries' => $GalleryRepository->countAmountGalleries()
        ]);
    }
}