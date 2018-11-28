<?php
/**
 * Created by PhpStorm.
 * User: stas.pivchenko
 * Date: 11/28/18
 * Time: 1:37 PM
 */

namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $register_form = $this->createForm(UserType::class, $user);
        $register_form->handleRequest($request);
        if ($register_form->isSubmitted() && $register_form->isValid())
        {
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $user->setRole('ROLE_USER');
            $data = $register_form->getData();
            if ($register_form->get('requestedRole')->getData())
            {
                $user->setRequestedRole('ROLE_BLOGGER');
            }
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }


        return $this->render('register/index.html.twig', array(
            'register_form' => $register_form->createView(),
        ));
    }
}