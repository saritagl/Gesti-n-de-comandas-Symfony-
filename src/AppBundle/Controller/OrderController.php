<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Order;
use AppBundle\Entity\OrderItem;
use AppBundle\Entity\Invoice;
use AppBundle\Entity\InvoiceItem;
use AppBundle\Entity\Table;


/**
 * @Route("/order")
 */
class OrderController extends Controller
{
    /**
     * @Route("/", name="order_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $server = $this->getUser();
        $repository = $this->getDoctrine()->getRepository('AppBundle:Order');
        $orders = $repository->findBy(array('server' => $server));

        return $this->render('order/index.html.twig', array('orders' => $orders));
    }

    /**
     * @Route("/open", name="order_open")
     * @Method({"GET", "POST"})
     */
    public function openAction(Request $request)
    {
        $order = new Order();

        if ($request->getMethod() == 'POST') {

            $repository = $this->getDoctrine()->getRepository('AppBundle:Table');
            $table = $repository->findOneBy(array(
                'number' => $request->get('table'))
            );

            if ( !$table || !$table->getIsAvailable() ) {
                if( !$table ) {
                    $this->addFlash('notice', 'La mesa no es válida!');
                } else {
                    $this->addFlash('notice', 'La mesa no está disponible!');
                }
            } else {
                $em = $this->getDoctrine()->getManager();
                $order->setServer($this->getUser());
                $table->setIsAvailable(False);
                $order->setTable($table);
                $em->persist($order);
                $em->persist($table);
                $em->flush();
                return $this->redirectToRoute('order_build', array('id' => $order->getId()));
            }
        }

        return $this->render('order/open.html.twig', array(
            'order' => $order
        ));
    }

    /**
     * @Route("/{id}/build", name="order_build")
     * @Method({"GET", "POST"})
     */
    public function buildAction(Request $request, Order $order)
    {
        $orderItem = new OrderItem();
        $form = $this->createForm('AppBundle\Form\Order\OrderBuildType', $orderItem);
        $form->handleRequest($request);

        $repository = $this->getDoctrine()->getRepository('AppBundle:OrderItem');
        $items = $repository->findBy(array('order' => $order->getId()));

        if ($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $orderItem->setOrder($order);
            $order->setTotal($order->getTotal() +
            $orderItem->getProduct()->getPrice() * $orderItem->getAmount());
            $em->persist($orderItem);
            $em->flush();

            return $this->redirectToRoute('order_build', array('id' => $order->getId()));

        }

        return $this->render('order/build.html.twig', array(
            'order' => $order,
            'form' => $form->createView(),
            'items' => $items,
        ));
    }

    /**
     * @Route("/{id}/close", name="order_close")
     * @Method({"GET", "POST"})
     */
    public function closeAction(Request $request, Order $order)
    {
        $invoice = new Invoice();

        if ($request->getMethod() == "POST") {

            $repository = $this->getDoctrine()->getRepository('AppBundle:Client');
            $client = $repository->findOneBy(array('ci' => $request->get('ci')));

            if(!$client){
                $this->addFlash('notice', 'Cédula inválida!');
                $errors = True;
            }
            if($order->getTotal() == 0){
                $this->addFlash('notice', 'La orden está vacía!');
                $errors = True;
            }

            if(!$errors){

                $invoice->setServer($order->getServer());
                $invoice->setTable($order->getTable());

                $repository = $this->getDoctrine()->getRepository('AppBundle:OrderItem');
                $orderItems = $repository->findBy(array('order' => $order->getId()));

                $em = $this->getDoctrine()->getManager();

                foreach($orderItems as $orderItem){
                    $invoiceItem = new InvoiceItem();
                    $invoiceItem->setInvoice($invoice);
                    $invoiceItem->setProduct($orderItem->getProduct());
                    $invoiceItem->setAmount($orderItem->getAmount());
                    $em->persist($invoiceItem);
                    $em->remove($orderItem);
                }

                $invoice->getTable()->setIsAvailable(True);
                $invoice->setTotal($order->getTotal());
                $invoice->setClient($client);
                $em->persist($invoice);
                $em->remove($order);
                $em->flush();

                return $this->redirectToRoute('order_index');
            }
        }

        return $this->render('order/close.html.twig', array(
            'invoice' => $invoice,
            'order' => $order,
        ));
    }

}
