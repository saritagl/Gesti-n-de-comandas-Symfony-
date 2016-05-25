<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    public function load(ObjectManager $manager)
    {
        $passwordEncoder = $this->container->get('security.password_encoder');

        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $encodedPassword = $passwordEncoder->encodePassword($userAdmin, 'test');
        $userAdmin->setPassword($encodedPassword);
        $userAdmin->setRoles(array('ROLE_ADMIN'));
        $userAdmin->setEmail('admin@domain.com');
        $manager->persist($userAdmin);

        $userMesonero = new User();
        $userMesonero->setUsername('john');
        $encodedPassword = $passwordEncoder->encodePassword($userMesonero, 'test');
        $userMesonero->setPassword($encodedPassword);
        $userMesonero->setRoles(array('ROLE_SERVER'));
        $userMesonero->setEmail('mesonero@domain.com');
        $manager->persist($userMesonero);

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
