<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\{
    DataFixtures\AbstractFixture,
    DataFixtures\OrderedFixtureInterface,
    Persistence\ObjectManager
};
use Symfony\Component\DependencyInjection\{
    ContainerInterface,
    ContainerAwareInterface
};

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface, ORMFixtureInterface, ContainerAwareInterface
{
    /**
     *
     * @var ContainerInterface
     */
    private $container;

    public function getOrder(): int
    {
        return 0;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager): void
    {
        $userList = [
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => 'admin',
                'fullName' => 'admin',
                'role' => 'ROLE_USER'
            ],
            [
                'username' => 'admin1',
                'email' => 'admin1@example.com',
                'password' => 'admin1',
                'fullName' => 'admin1',
                'role' => 'ROLE_ADMIN'
            ],
        ];

        $encoderFactory = $this->container->get('security.encoder_factory');

        foreach ($userList as $details) {
            $user = new User();

            $password = $encoderFactory->getEncoder($user)->encodePassword($details['password'], null);

            $user->setUsername($details['username']);
            $user->setEmail($details['email']);
            $user->setPassword($password);
            $user->setFullName($details['fullName']);
            $user->setRoles(array($details['role']));

            $this->addReference('user-' . $details['username'], $user);

            $manager->persist($user);
        }
        $manager->flush();
    }
}