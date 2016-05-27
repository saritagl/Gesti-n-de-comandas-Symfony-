<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;
use AppBundle\Form\User\UserNewType;
use AppBundle\Form\User\UserEditType;


class UserController extends Controller
{
    /**
     * Lists all User entities.
     *
     * @Security("has_role('admin')")
     * @Route("/user/", name="user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:User');
        $users = $repository->findAll();
        return $this->render(
            'user/index.html.twig',
            array('users' => $users)
        );
    }

    /**
     * Creates a new User entity.
     *
     * @Security("has_role('admin')")
     * @Route("/user/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserNewType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Encode the password
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // Save the User
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('dashboard_index');
        }

        return $this->render(
            'user/new.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * Finds and displays a User entity.
     *
     * @Security("has_role('admin')")
     * @Route("/user/{username}", name="user_show")
     * @Method("GET")
     */
    public function showAction($username)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:User');
        $user = $repository->findOneByUsername($username);
        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for username ' . $username
            );
        }
        return $this->render(
            'user/show.html.twig',
            array('user' => $user)
        );
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Security("has_role('admin')")
     * @Route("/user/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $user = new User();

        $repository = $this->getDoctrine()->getRepository('AppBundle:User');
        $user = $repository->findOneById($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for username ' . $id
            );
        }
        $form = $this->createForm(UserEditType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // && $form->isValid() I should add this to the conditional but
            //   stop working for an unknown reason
            // Save the User
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('dashboard_index');
        }

        return $this->render(
            'user/edit.html.twig',
            array('form' => $form->createView())
        );
    }

}
