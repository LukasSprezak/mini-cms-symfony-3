<?php

namespace AppBundle\Traits;

use AppBundle\Entity\Post\Post;

trait PaginatedPostTrait
{
    protected function getPaginatedPosts(array $params = [], string $page)
    {
        $postRepository = $this->getDoctrine()->getRepository(Post::class);
        $query = $postRepository
            ->createListQueryBuilder($params);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $page,
            $this->postLimit
        );

        return $pagination;
    }
}