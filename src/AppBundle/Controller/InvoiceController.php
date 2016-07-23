<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Invoice;

/**
 * @Route("/invoice")
 */
class InvoiceController extends Controller
{
    /**
     * @Route("/", name="invoice_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('invoice/index.html.twig');
    }

    /**
     * Finds and displays a invoice.
     *
     * @Route("/{id}", name="invoice_show")
     * @Method("GET")
     */
    public function showAction(Invoice $invoice)
    {
        $invoiceItems = $invoice->getItems();

        return $this->render('invoice/show.html.twig', array(
            'invoice' => $invoice,
            'items' => $invoiceItems,
        ));
    }

    /**
     * @Route("/{type}/{firstDay}/{lastDay}", name="invoice_report")
     * @Method({"GET"})
     */
    public function reportAction(Request $request, $type, $firstDay, $lastDay)
    {
        $em = $this->getDoctrine()->getManager();
        $rows = $em->getRepository('AppBundle:Invoice')
            ->reportBy($type, $firstDay, $lastDay);

        return $this->render(
            'invoice/by' . ucfirst($type) .'.html.twig',
            array('rows' => $rows)
        );
    }
}
