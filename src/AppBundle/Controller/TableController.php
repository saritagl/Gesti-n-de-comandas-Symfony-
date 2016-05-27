<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Table;
use AppBundle\Form\Table\TableNewType;
use AppBundle\Form\Table\TableEditType;

/**
 * Table controller.
 *
 * @Route("/table")
 */
class TableController extends Controller
{
    /**
     * Lists all Table entities.
     *
     * @Route("/", name="table_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tables = $em->getRepository('AppBundle:Table')->findAll();

        return $this->render('table/index.html.twig', array(
            'tables' => $tables,
        ));
    }

    /**
     * Creates a new Table entity.
     *
     * @Route("/new", name="table_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $table = new Table();
        $form = $this->createForm('AppBundle\Form\Table\TableNewType', $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($table);
            $em->flush();

            return $this->redirectToRoute('table_show', array('id' => $table->getId()));
        }

        return $this->render('table/new.html.twig', array(
            'table' => $table,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Table entity.
     *
     * @Route("/{id}", name="table_show")
     * @Method("GET")
     */
    public function showAction(Table $table)
    {
        $deleteForm = $this->createDeleteForm($table);

        return $this->render('table/show.html.twig', array(
            'table' => $table,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Table entity.
     *
     * @Route("/{id}/edit", name="table_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Table $table)
    {
        $editForm = $this->createForm('AppBundle\Form\Table\TableEditType', $table);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            if( $editForm->get('delete')->isClicked() ){
                $em->remove($table);
                $em->flush();
                return $this->redirectToRoute('table_index');
            } else {
                $em->flush();
                return $this->redirectToRoute('table_show', array('id' => $table->getId()));
            }

        }

        return $this->render('table/edit.html.twig', array(
            'table' => $table,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Table entity.
     *
     * @Route("/{id}", name="table_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Table $table)
    {
        $form = $this->createDeleteForm($table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($table);
            $em->flush();
        }

        return $this->redirectToRoute('table_index');
    }

    /**
     * Creates a form to delete a Table entity.
     *
     * @param Table $table The Table entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Table $table)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('table_delete', array('id' => $table->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
