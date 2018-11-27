<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $utils)
    {
//        $user = new User();
//        $form = $this->createFormBuilder($user)
//            ->setAction($this->generateUrl('login'))
//            ->setMethod('POST')
//            ->add('email', TextType::class, array('attr' => array('name' => '_username', 'id' => 'username')))
//            ->add('password', TextType::class, array('attr' => array('name' => '_password', 'id' => 'password')))
//            ->add('Login', SubmitType::class, array('label' => 'Login'))
//            ->getForm();
//        $form->handleRequest($request);
        $errors = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();
//        if ($form->isSubmitted() && $form->isValid()) {
//            $user = $form->getData();
//            return $this->render('login/index.html.twig', array(
//                'username' => $lastUsername,
//                'password' => $user->getPassword(),
//                'errors' => $errors,
//                'form' => $form->createView(),
//            ));
////            return $this->redirectToRoute('login/index.html.twig');
//        }
        return $this->render('login/index.html.twig', array(
            'username' => $lastUsername,
            'errors' => $errors,
        ));
//        return $this->render('login/index.html.twig', [
//            'controller_name' => 'LoginController',
//        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(){

    }
}
