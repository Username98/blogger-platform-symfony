<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginForm;
use App\Form\UserType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $utils, UserPasswordEncoderInterface $encoder)
    {
        $errors = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();
        $form = $this->createForm(LoginForm::class, [
            'username' => $lastUsername,
        ]);

//        $em = $this->getDoctrine()->getManager();
//        $user = new User();
//        $register_form = $this->createForm(UserType::class, $user);
//        $register_form->handleRequest($request);
//        if ($register_form->isSubmitted() && $register_form->isValid())
//        {
//            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
//            $em->persist($user);
//            $em->flush();
//
//            return $this->redirectToRoute('login');
//        }


        return $this->render('login/index.html.twig', array(
            'form' => $form->createView(),
            'errors' => $errors,
//            'register_form' => $register_form->createView(),
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(){

    }
}
