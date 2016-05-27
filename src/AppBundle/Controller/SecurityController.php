<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login_form")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    /**
     * This is the route the login form submits to.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the login automatically. See form_login in app/config/security.yml
     *
     * @Route("/login_check", name="security_login_check")
     */
    public function loginCheckAction()
    {
        throw new \Exception('This should never be reached!');
    }

    /**
     * This is the route the user can use to logout.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the logout automatically. See logout in app/config/security.yml
     *
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        throw new \Exception('This should never be reached!');
    }

    /**
     * Displays a form to update the password.
     *
     * @Route("/updatePassword", name="security_update_password")
     * @Method({"GET", "POST"})
     */
    public function updatePasswordAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $session = $request->getSession();
        $data['msg'] = "";

        if ($request->getMethod() == 'POST') {
            $old_pwd = $request->get('old_password');
            $new_pwd = $request->get('new_password');
            $rep_pwd = $request->get('rep_password');
            $user = $this->getUser();
            $encoder  = $this->get('security.encoder_factory')->getEncoder($user);

            /*if (!password_verify($old_pwd, $user->getPassword())) {
              // the above statement have to be used strictly with bcrypt //
              // the statement below is encrypt method agnostic */
            if(!$encoder->isPasswordValid($user->getPassword(), $old_pwd, $user->getSalt()) ) {
                $data['msg'] = "Wrong old password! ";
            } else {
                if( $new_pwd != $rep_pwd) {
                    $data['msg'] = "Last two password inputs are diferent";
                } else {
                    $new_pwd_encoded = $encoder->encodePassword($new_pwd, $user->getSalt());
                    $user->setPassword($new_pwd_encoded);
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($user);

                    $manager->flush();
                    $data['msg'] = "Password changed successfully!";
                }
            }
            return $this->render('security/update_password.html.twig', array('data' => $data));
        }

        return $this->render('security/update_password.html.twig', array('data' => $data));
    }

    /**
     * Switch the user's rol and redisplay the dashboard
     *
     * @Route("/switchRole/{role}", name="security_switch_role")
     * @Method({"GET", "POST"})
     */
    public function switchRoleAction(Request $request, $role)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();

        if ( !in_array($role, $user->getRoles()) ) {
            throw $this->createAccessDeniedException();
        }

        $user->setLastRole($role);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        $manager->flush();

        return $this->redirectToRoute('dashboard_index');
    }

}
