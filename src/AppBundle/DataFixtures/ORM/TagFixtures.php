<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Post\Tag;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\{
    DataFixtures\AbstractFixture,
    DataFixtures\OrderedFixtureInterface,
    Persistence\ObjectManager
};

class TagFixtures extends AbstractFixture implements OrderedFixtureInterface, ORMFixtureInterface
{
    public function getOrder(): int
    {
        return 0;
    }

    public function load(ObjectManager $manager): void
    {
        $tagList = [
            'lorem',
            'ipsum',
            'dolor',
            'sit',
            'amet',
            'consectetur',
            'adipiscing',
            'elit',
            'Duis',
            'sed',
            'quis',
        ];

        foreach ($tagList as $value => $name) {
            $tag = new tag();
            $tag->setName($name);

            $manager->persist($tag);
            $this->addReference('tag_' . $name, $tag);
        }
        $manager->flush();
    }
}