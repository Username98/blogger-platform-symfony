<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordForm;
use App\Model\ChangePassword;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $changePasswordModel = new ChangePassword();
        $form = $this->createForm(ChangePasswordForm::class, $changePasswordModel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // perform some action,
            // such as encoding with MessageDigestPasswordEncoder and persist
            $user = $this->getUser();
            $user->setPassword($encoder->encodePassword($user, $form->get('newPassword')->getData()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('profile');
        }

        return $this->render('profile/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
