<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Page;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class PageFixtures extends AbstractFixture implements ORMFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $pageList = [
            [
                'title' => 'Title One',
                'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc et volutpat arcu. Aliquam erat volutpat. Mauris luctus egestas interdum. Etiam id accumsan nunc. Curabitur augue nulla, fermentum sit amet magna eget, aliquam hendrerit libero. Integer interdum elit lacus, non scelerisque felis egestas a. In hac habitasse platea dictumst. </p>',
                'enabled' => '1',
                'description' => 'Lorem ipsum',
                'keywords' => 'Lorem ipsum',
                'alias' => 'site-one',
                'createdAt' => '2019-01-01 12:12:12',
                'hidden_sidebar' => '1',
            ],
            [
                'title' => 'Title Two',
                'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc et volutpat arcu. Aliquam erat volutpat. Mauris luctus egestas interdum. Etiam id accumsan nunc. Curabitur augue nulla, fermentum sit amet magna eget, aliquam hendrerit libero. Integer interdum elit lacus, non scelerisque felis egestas a. In hac habitasse platea dictumst. </p>',
                'enabled' => '1',
                'description' => 'Lorem ipsum',
                'keywords' => 'Lorem ipsum',
                'alias' => 'site-two',
                'createdAt' => '2019-01-01 12:12:12',
                'hidden_sidebar' => '1',
            ],
        ];

        foreach ($pageList as $index => $details) {
            $page = new Page();

            $page->setTitle($details['title']);
            $page->setContent($details['content']);
            $page->setEnabled($details['enabled']);
            $page->setDescription($details['description']);
            $page->setKeywords($details['description']);
            $page->setAlias($details['alias']);
            $page->setCreatedAt(new \DateTime($details['createdAt']));
            $page->setHiddenSidebar($details['hidden_sidebar']);

            $this->addReference('page-' . $index, $page);

            $manager->persist($page);
        }
        $manager->flush();
    }
}