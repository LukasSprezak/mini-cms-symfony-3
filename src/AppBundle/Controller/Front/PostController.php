<?php

declare(strict_types=1);

namespace AppBundle\Controller\Front;

use AppBundle\Traits\PaginatedPostTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\{
    Post\Category,
    Post\Post,
    Post\Tag
};
use Symfony\Component\{
    HttpFoundation\Response,
    Routing\Annotation\Route
};

class PostController extends Controller
{
    use PaginatedPostTrait;

    /**
     * @Route("/blog/{page}/", name="blog_index", methods={"GET"}, defaults={"page"=1}, requirements={"page"="\d+"})
     * @param $page
     * @return Response
     */
    public function indexAction(string $page)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $activeStatusPosts = $entityManager->getRepository(Post::class)
            ->findActiveStatus();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $activeStatusPosts,
            $page,
            $this->postLimit
        );

        return $this->render("Front/index.html.twig", [
            'pagination' => $pagination,
            'listTitle' => 'Najnowsze wpisy'
        ]);
    }

    /**
     * @Route("/blog/{slug}",name="blog_post", methods={"GET"})
     * @param $slug
     * @return Response
     */
    public function postAction(string $slug)
    {
      $postRepository =  $this->getDoctrine()->getRepository(Post::class);
      $post = $postRepository
          ->findPublishedPost($slug);

      if (null === $post) {
          throw $this->createNotFoundException('front.post_exception');
      }

      return $this->render("Front/post.html.twig", [
            'post' => $post
      ]);
    }

    /**
     * @Route("/category/{slug}/{page}", name="blog_category", methods={"GET"}, defaults={"page"=1}, requirements={"page"="\d+"})
     * @param $slug
     * @param $page
     * @return Response
     */
    public function categoryAction(string $slug, string $page)
    {
        $pagination = $this->getPaginatedPosts([
            'categorySelectedSlug' => $slug
        ], $page);

        $categoryRepository = $this->getDoctrine()->getRepository( Category::class);
        $category = $categoryRepository
            ->findOneBySlug($slug);

        return $this->render("Front/index.html.twig", [
            'pagination' => $pagination,
            'listTitle' => sprintf('Wpisy w kategorii "%s"', $category->getName())
        ]);
    }

    /**
     * @Route("/tag/{slug}/{page}", name="blog_tag", methods={"GET"}, defaults={"page"=1}, requirements={"page"="\d+"})
     * @param $slug
     * @param $page
     * @return Response
     */
    public function tagAction(string $slug, string $page)
    {
        $TagRepository = $this->getDoctrine()->getRepository(Tag::class);
        $Tag = $TagRepository
            ->findOneBySlug($slug);

        $pagination = $this->getPaginatedPosts([
            'tagSlug' => $slug
        ], $page);

        return $this->render("Front/index.html.twig", [
            'pagination' => $pagination,
            'listTitle' => sprintf('Wpisy z tagiem "%s"', $Tag->getName())
        ]);
    }

    protected $postLimit = 6;
}