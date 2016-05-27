<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use AppBundle\Entity\Product;
use AppBundle\Entity\Category;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class LoadFixtures implements FixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadMenu($manager);
        //$this->loadClients($manager);
    }

    public function loadUsers(ObjectManager $manager)
    {
        $passwordEncoder = $this->container->get('security.password_encoder');

        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $encodedPassword = $passwordEncoder->encodePassword($userAdmin, 'test');
        $userAdmin->setPassword($encodedPassword);
        $userAdmin->setRoles(array('admin'));
        $userAdmin->setLastRole('admin');
        $userAdmin->setEmail('admin@domain.com');
        $manager->persist($userAdmin);

        $userServer = new User();
        $userServer->setUsername('server');
        $encodedPassword = $passwordEncoder->encodePassword($userServer, 'test');
        $userServer->setPassword($encodedPassword);
        $userServer->setRoles(array('server'));
        $userServer->setLastRole('server');
        $userServer->setEmail('server@domain.com');
        $manager->persist($userServer);

        $manager->flush();
    }

    public function loadMenu(ObjectManager $manager)
    {
        $categoryBurger = new Category();
        $categoryBurger->setName('Burger');
        $categoryBurger->setDescription('...');
        $manager->persist($categoryBurger);

        $productChickenBurger = new Product();
        $productChickenBurger->setName('Chicken Burger');
        $productChickenBurger->setPrice(20.39);
        $productChickenBurger->setDescription('...');
        $productChickenBurger->setCategory($categoryBurger);
        $manager->persist($productChickenBurger);

        $productCheeseBurger = new Product();
        $productCheeseBurger->setName('Cheese Burger');
        $productCheeseBurger->setPrice(45.39);
        $productCheeseBurger->setDescription('...');
        $productCheeseBurger->setCategory($categoryBurger);
        $manager->persist($productCheeseBurger);


        $categoryDessert = new Category();
        $categoryDessert->setName('Dessert');
        $categoryDessert->setDescription('...');
        $manager->persist($categoryDessert);

        $productRaspberryBrownie = new Product();
        $productRaspberryBrownie->setName('Raspberry Brownie Royale');
        $productRaspberryBrownie->setPrice(32.24);
        $productRaspberryBrownie->setDescription('...');
        $productRaspberryBrownie->setCategory($categoryDessert);
        $manager->persist($productRaspberryBrownie);

        $productRedVelvet = new Product();
        $productRedVelvet->setName('Red Velvet Cake');
        $productRedVelvet->setPrice(63.29);
        $productRedVelvet->setDescription('...');
        $productRedVelvet->setCategory($categoryDessert);
        $manager->persist($productRedVelvet);

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
