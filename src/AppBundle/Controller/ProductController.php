<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Product;
use AppBundle\Form\Product\ProductNewType;
use AppBundle\Form\Product\ProductEditType;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @Route("/product")
 */
class ProductController extends Controller
{
    /**
     * Lists all Product entities.
     *
     * @Route("/", name="product_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Product')->findAll();

        return $this->render('product/index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Creates a new Product entity.
     *
     * @Route("/new", name="product_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('AppBundle\Form\Product\ProductNewType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $file stores the uploaded image file
            $file = $product->getFile();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$product->getFile()->guessExtension();

            // Move the file to the directory where image are stored
            $file->move(
                $this->container->getParameter('product_image_directory'),
                $fileName
            );

            // Update the 'image' property to store the jpeg file name
            // instead of its content
            $product->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_show', array('id' => $product->getId()));
        }

        return $this->render('product/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Product entity.
     *
     * @Route("/{id}", name="product_show")
     * @Method("GET")
     */
    public function showAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('product/show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     * @Route("/{id}/edit", name="product_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Product $product)
    {
        $editForm = $this->createForm('AppBundle\Form\Product\ProductEditType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isValid()){

            $em = $this->getDoctrine()->getManager();
            if( $editForm->get('delete')->isClicked() ){
                $em->remove($product);
                $em->flush();
                return $this->redirectToRoute('product_index');
            } else {
                // $file stores the uploaded image file
                $file = $product->getFile();

                // check whether a new image was uploaded.
                if($file != null){
                    // Generate a unique name for the file before saving it
                    $fileName = md5(uniqid()).'.'.$product->getFile()->guessExtension();

                    // Move the file to the directory where image are stored
                    $file->move(
                        $this->container->getParameter('product_image_directory'),
                        $fileName
                    );

                    // Update the 'image' property to store the jpeg file name
                    // instead of its content
                    $product->setImage($fileName);
                }
                $em->flush();
                return $this->redirectToRoute('product_show', array('id' => $product->getId()));
            }

        }

        return $this->render('product/edit.html.twig', array(
            'product' => $product,
            'form' => $editForm->createView(),
            'image' => 'uploads/product/' . $product->getImage()
        ));
    }

    /**
     * Deletes a Product entity.
     *
     * @Route("/{id}", name="product_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('product_index');
    }

    /**
     * Creates a form to delete a Product entity.
     *
     * @param Product $product The Product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
