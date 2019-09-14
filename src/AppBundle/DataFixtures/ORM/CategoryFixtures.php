<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Post\Category;
use Doctrine\{
    Bundle\FixturesBundle\ORMFixtureInterface,
    Common\DataFixtures\AbstractFixture,
    Common\DataFixtures\OrderedFixtureInterface,
    Common\Persistence\ObjectManager
};

class CategoryFixtures extends AbstractFixture implements OrderedFixtureInterface, ORMFixtureInterface
{
    public function getOrder(): int
    {
        return 0;
    }

    public function load(ObjectManager $manager): void
    {
        $categoryList = [
            'categoryOne' => 'category-one',
            'categoryTwo' => 'category-two',
            'categoryThree' => 'category-three',
            'categoryFour' => 'category-four',
            'categoryFive' => 'category-five'
        ];

        foreach ($categoryList as $value => $name) {
            $category = new Category();
            $category->setName($name);

            $manager->persist($category);
            $this->addReference('category_' . $value, $category);
        }
        $manager->flush();
    }
}