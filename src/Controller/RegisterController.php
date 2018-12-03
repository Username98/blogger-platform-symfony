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
use App\Mailer\Mailer;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
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
            try {
                $user->setConfirmationToken(rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '='));
            } catch (\Exception $e) {
            }
            $user->setEnabled(0);
            $data = $register_form->getData();
            if ($register_form->get('requestedRole')->getData())
            {
                $user->setRequestedRole('ROLE_BLOGGER');
            }
            $em->persist($user);
            $em->flush();

            $message_content = $this->render('register/email.html.twig',
                array('user'=>$user, 'confirmationUrl'=>'http://bloggersplatform.loc/register/confirm/'.$user->getConfirmationToken()));
            $transport = (new Swift_SmtpTransport('ssl://smtp.gmail.com', 465))
                ->setUsername('pivchenko.stas.1999@gmail.com')
                ->setPassword('stas10041999')
            ;

            // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);

            // Create a message
            $message = (new Swift_Message('Bloggers Platform confirmation email'))
                ->setFrom(['noreply@bp.com' => 'Bloggers Platform'])
                ->setTo([$user->getEmail() => 'A name'])
                ->setBody($message_content);
            ;
            $result = $mailer->send($message);

            return $this->redirectToRoute('login');
        }


        return $this->render('register/index.html.twig', array(
            'register_form' => $register_form->createView(),
        ));
    }

    /**
     * @Route("/register/confirm/{slug}", name="confirm")
     */
    public function confirmAction(Request $request, $slug){
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneBy(['confirmationToken' => $slug]);
        if ($user)
        {
            $em = $this->getDoctrine()->getManager();
            $user->setEnabled(true)
                 ->setConfirmationToken(null);
            $em->persist($user);
            $em->flush();
        }
        return $this->redirectToRoute('login');
    }
}