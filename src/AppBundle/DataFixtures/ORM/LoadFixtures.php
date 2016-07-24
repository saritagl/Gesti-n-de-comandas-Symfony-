<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use AppBundle\Entity\Product;
use AppBundle\Entity\Category;
use AppBundle\Entity\Client;
use AppBundle\Entity\Table;
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
        $this->loadClients($manager);
        $this->loadTables($manager);
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

        $userServer1 = new User();
        $userServer1->setUsername('server1');
        $encodedPassword = $passwordEncoder->encodePassword($userServer1, 'test');
        $userServer1->setPassword($encodedPassword);
        $userServer1->setRoles(array('server'));
        $userServer1->setLastRole('server');
        $userServer1->setEmail('server1@domain.com');
        $manager->persist($userServer1);

        $userServer2 = new User();
        $userServer2->setUsername('server2');
        $encodedPassword = $passwordEncoder->encodePassword($userServer2, 'test');
        $userServer2->setPassword($encodedPassword);
        $userServer2->setRoles(array('server'));
        $userServer2->setLastRole('server');
        $userServer2->setEmail('server2@domain.com');
        $manager->persist($userServer2);

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
        $productChickenBurger->setImage('30609a0be43aee3a5deac0947acb96ca.jpeg');
        $manager->persist($productChickenBurger);

        $productCheeseBurger = new Product();
        $productCheeseBurger->setName('Cheese Burger');
        $productCheeseBurger->setPrice(45.39);
        $productCheeseBurger->setDescription('...');
        $productCheeseBurger->setCategory($categoryBurger);
        $productCheeseBurger->setImage('32620c7e08442cf2d66f13e85602e347.jpeg');
        $manager->persist($productCheeseBurger);

        $productBaconBurger = new Product();
        $productBaconBurger->setName('Bacon Burger');
        $productBaconBurger->setPrice(35.39);
        $productBaconBurger->setDescription('...');
        $productBaconBurger->setCategory($categoryBurger);
        $productBaconBurger->setImage('9ccb952a2874e93b74143fb0fe73839d.jpeg');
        $manager->persist($productBaconBurger);

        $productChilliBurger = new Product();
        $productChilliBurger->setName('Chilli Burger');
        $productChilliBurger->setPrice(42.39);
        $productChilliBurger->setDescription('...');
        $productChilliBurger->setCategory($categoryBurger);
        $productChilliBurger->setImage('b227a5c8bbb251da54ac829e79561b17.jpeg');
        $manager->persist($productChilliBurger);


        $categoryDessert = new Category();
        $categoryDessert->setName('Dessert');
        $categoryDessert->setDescription('...');
        $manager->persist($categoryDessert);

        $productRaspberryBrownie = new Product();
        $productRaspberryBrownie->setName('Raspberry Brownie Royale');
        $productRaspberryBrownie->setPrice(32.24);
        $productRaspberryBrownie->setDescription('...');
        $productRaspberryBrownie->setCategory($categoryDessert);
        $productRaspberryBrownie->setImage('9ac6f2a1b1f4fade9d181197aa0fc59c.jpeg');
        $manager->persist($productRaspberryBrownie);

        $productRedVelvet = new Product();
        $productRedVelvet->setName('Red Velvet Cake');
        $productRedVelvet->setPrice(63.29);
        $productRedVelvet->setDescription('...');
        $productRedVelvet->setCategory($categoryDessert);
        $productRedVelvet->setImage('3aad5a33e4165a7edf4ae9d45e439449.jpeg');
        $manager->persist($productRedVelvet);

        $productCookieSandwich = new Product();
        $productCookieSandwich->setName('Chocolate Cookie Sandwich');
        $productCookieSandwich->setPrice(37.35);
        $productCookieSandwich->setDescription('...');
        $productCookieSandwich->setCategory($categoryDessert);
        $productCookieSandwich->setImage('f0670dd79d7724394c143e27ba72341b.jpeg');
        $manager->persist($productCookieSandwich);

        $productStrawberry = new Product();
        $productStrawberry->setName('Strawberry Cheese Cake');
        $productStrawberry->setPrice(57.29);
        $productStrawberry->setDescription('...');
        $productStrawberry->setCategory($categoryDessert);
        $productStrawberry->setImage('3feddfe0701a8db06441b974ee2aefdc.jpeg');
        $manager->persist($productStrawberry);


        $categorySteak = new Category();
        $categorySteak->setName('Steak');
        $categorySteak->setDescription('...');
        $manager->persist($categorySteak);

        $productFiletMedallions = new Product();
        $productFiletMedallions->setName('Filet Medallions');
        $productFiletMedallions->setPrice(102.24);
        $productFiletMedallions->setDescription('...');
        $productFiletMedallions->setCategory($categorySteak);
        $productFiletMedallions->setImage('9087d26fc2ac34e323dd3d811b579ad4.jpeg');
        $manager->persist($productFiletMedallions);

        $productFiletMignon = new Product();
        $productFiletMignon->setName('Filet Mignon');
        $productFiletMignon->setPrice(123.29);
        $productFiletMignon->setDescription('...');
        $productFiletMignon->setCategory($categorySteak);
        $productFiletMignon->setImage('69158b480896006ca3ba01b3881fe9f0.jpeg');
        $manager->persist($productFiletMignon);

        $productNewYorkStrips = new Product();
        $productNewYorkStrips->setName('New York Strip');
        $productNewYorkStrips->setPrice(300.35);
        $productNewYorkStrips->setDescription('...');
        $productNewYorkStrips->setCategory($categorySteak);
        $productNewYorkStrips->setImage('405aef2897e954e441f5edb5714bd4fb.jpeg');
        $manager->persist($productNewYorkStrips);

        $productRibEye = new Product();
        $productRibEye->setName('Rib Eye Filet');
        $productRibEye->setPrice(57.29);
        $productRibEye->setDescription('...');
        $productRibEye->setCategory($categorySteak);
        $productRibEye->setImage('89eeb9b98196a17ecbad7bcd27717a75.jpeg');
        $manager->persist($productRibEye);


        $categorySandwich = new Category();
        $categorySandwich->setName('Sandwich');
        $categorySandwich->setDescription('...');
        $manager->persist($categorySandwich);

        $productBigStock = new Product();
        $productBigStock->setName('Sandwich Big Stock');
        $productBigStock->setPrice(12.24);
        $productBigStock->setDescription('...');
        $productBigStock->setCategory($categorySandwich);
        $productBigStock->setImage('ee0ea43b18bc46016c0a79aa3374923f.jpeg');
        $manager->persist($productBigStock);

        $productFrenchBread = new Product();
        $productFrenchBread->setName('Sandwich French Bread');
        $productFrenchBread->setPrice(12.29);
        $productFrenchBread->setDescription('...');
        $productFrenchBread->setCategory($categorySandwich);
        $productFrenchBread->setImage('4c9dfc41acbc99f3fb6336a93e0b001e.jpeg');
        $manager->persist($productFrenchBread);

        $manager->flush();
    }

    public function loadClients(ObjectManager $manager)
    {
        $clientBob = new Client();
        $clientBob->setCi('13900943');
        $clientBob->setName('Bob Clain');
        $manager->persist($clientBob);

        $clientJohn = new Client();
        $clientJohn->setCi('18543800');
        $clientJohn->setName('John Smith');
        $manager->persist($clientJohn);

        $clientAlice = new Client();
        $clientAlice->setCi('896800');
        $clientAlice->setName('Alice Taylor');
        $manager->persist($clientAlice);

        $clientBeth = new Client();
        $clientBeth->setCi('1968050');
        $clientBeth->setName('Beth Jones');
        $manager->persist($clientBeth);

        $clientJoseph = new Client();
        $clientJoseph->setCi('1690050');
        $clientJoseph->setName('Joseph Green');
        $manager->persist($clientJoseph);

        $clientKenneth = new Client();
        $clientKenneth->setCi('25908050');
        $clientKenneth->setName('Kenneth Wood');
        $manager->persist($clientKenneth);

        $manager->flush();
    }

    public function loadTables(ObjectManager $manager){
        $tableOne = new Table();
        $tableOne->setNumber(1);
        $tableOne->setChairNumber(4);
        $tableOne->setIsAvailable(True);
        $manager->persist($tableOne);

        $tableTwo = new Table();
        $tableTwo->setNumber(2);
        $tableTwo->setChairNumber(6);
        $tableTwo->setIsAvailable(True);
        $manager->persist($tableTwo);

        $tableThree = new Table();
        $tableThree->setNumber(3);
        $tableThree->setChairNumber(4);
        $tableThree->setIsAvailable(True);
        $manager->persist($tableThree);

        $tableFour = new Table();
        $tableFour->setNumber(4);
        $tableFour->setChairNumber(6);
        $tableFour->setIsAvailable(True);
        $manager->persist($tableFour);

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
