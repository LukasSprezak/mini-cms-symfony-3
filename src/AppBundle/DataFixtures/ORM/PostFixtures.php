<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Post\Post;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\{
    DataFixtures\AbstractFixture,
    DataFixtures\OrderedFixtureInterface,
    Persistence\ObjectManager
};

class PostFixtures extends AbstractFixture implements OrderedFixtureInterface, ORMFixtureInterface
{
    public function getOrder(): int
    {
        return 1;
    }

    public function load(ObjectManager $manager): void
    {
        $postList = [
            [
                'title' => 'Title One',
                'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc et volutpat arcu. Aliquam erat volutpat. Mauris luctus egestas interdum. Etiam id accumsan nunc. Curabitur augue nulla, fermentum sit amet magna eget, aliquam hendrerit libero. Integer interdum elit lacus, non scelerisque felis egestas a. In hac habitasse platea dictumst. </p>',
                'status' => 'post.status_active',
                'BeginningText' => 'Lorem ipsum',
                'description' => 'Lorem ipsum',
                'keywords' => 'Lorem ipsum',
                'slug' => 'blog-site-one',
                'alt' => 'Lorem ipsum',
                'category' => 'category-four',
                'tags' => ['amet', 'dolor'],
                'author' => 'admin1',
                'createDate' => '2019-01-01 12:12:12',
                'publishedDate' => '2019-01-01 12:12:12',
            ],
            [
                'title' => 'Title Two',
                'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc et volutpat arcu. Aliquam erat volutpat. Mauris luctus egestas interdum. Etiam id accumsan nunc. Curabitur augue nulla, fermentum sit amet magna eget, aliquam hendrerit libero. Integer interdum elit lacus, non scelerisque felis egestas a. In hac habitasse platea dictumst. </p>',
                'status' => 'post.status_active',
                'BeginningText' => 'Lorem ipsum',
                'description' => 'Lorem ipsum',
                'keywords' => 'Lorem ipsum',
                'slug' => 'blog-site-two',
                'alt' => 'Lorem ipsum',
                'category' => 'category-five',
                'tags' => ['consectetur', 'adipiscing', 'elit'],
                'author' => 'admin1',
                'createDate' => '2019-01-01 12:12:12',
                'publishedDate' => '2019-01-01 12:12:12',
            ],
        ];

        foreach ($postList as $index => $details) {
            $post = new Post();

            $post->setTitle($details['title']);
            $post->setContent($details['content']);
            $post->setStatus($details['status']);
            $post->setBeginningText($details['BeginningText']);
            $post->setDescription($details['description']);
            $post->setKeywords($details['description']);
            $post->setslug($details['slug']);
            $post->setAlt($details['alt']);
            $post->setAuthor($this->getReference('user-'.$details['author']));
            $post->setCreateDate(new \DateTime($details['createDate']));

            if(null !== $details['publishedDate']){
                $post->setPublishedDate(new \DateTime($details['publishedDate']));
            }

       //     $post->setCategory($this->getReference('category_'.$details['category']));

            foreach($details['tags'] as $tagName){
                $post->addTag($this->getReference('tag_'.$tagName));
            }

            $this->addReference('post-' . $index, $post);

            $manager->persist($post);
        }
        $manager->flush();
    }
}