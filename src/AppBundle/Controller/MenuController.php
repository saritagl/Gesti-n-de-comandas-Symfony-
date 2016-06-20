<?php
/**
 * Created by PhpStorm.
 * User: oruiz
 * Date: 6/17/16
 * Time: 12:24 PM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Product;
use AppBundle\Controller\CategoryController;


/**
 * Class MenuController
 * @Route("/menu")
 */
class MenuController extends Controller
{
    /**
     * Show all menu items
     *
     * @Route("/", name="menu_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Product')->findAll();
        $categories = $em->getRepository('AppBundle:Category')->findAll();
    
        return $this->render('menu/index.html.twig', array(
            'menu' => $products,
            'categories' => $categories
        ));
    }


    /**
     * Finds and displays a menu item.
     *
     * @Route("/{id}", name="menu_show")
     * @Method("GET")
     */
    public function showAction(Product $product)
    {
       return $this->render('menu/show.html.twig', array(
            'item' => $product
        ));
    }
}