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
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
//    /**
//     * @Route("/register", name="register")
//     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('');
        }
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

            $transport = (new Swift_SmtpTransport('ssl://smtp.gmail.com', 465))
                ->setUsername('pivchenko.stas.1999@gmail.com')
                ->setPassword('Stas_10041999')
            ;

            // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);

            // Create a message
            $message = (new Swift_Message('Wonderful Subject'))
                ->setFrom(['pivchenko.stas.1999@gmail.com' => 'John Doe'])
                ->setTo([$user->getEmail() => 'A name'])
                ->setBody('Here is the message itself')
            ;

            // Send the message
            $result = $mailer->send($message);

            return $this->redirectToRoute('login');
        }


        return $this->render('register/index.html.twig', array(
            'register_form' => $register_form->createView(),
        ));
    }
}