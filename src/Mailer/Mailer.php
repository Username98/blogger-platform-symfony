<?php
/**
 * Created by PhpStorm.
 * User: stas.pivchenko
 * Date: 12/3/18
 * Time: 1:42 AM
 */

namespace App\Mailer;


use App\Entity\User;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class Mailer
{
    /**
     * @var EngineInterface
     */
    protected $templating;

    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    public function sendConfirmationEmailMessage(User $user){
        $message_content = $this->templating->render('register/email.html.twig',
            array('user'=>$user, 'confirmationURL'=>'http://bloggersplatform.loc/register/confirm/'.$user->getConfirmationToken()));
        $transport = (new Swift_SmtpTransport('ssl://smtp.gmail.com', 465))
            ->setUsername('pivchenko.stas.1999@gmail.com')
            ->setPassword('Stas_10041999')
        ;

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        $message = (new Swift_Message('Bloggers Platform confirmation email'))
            ->setFrom(['noreply@bp.com' => 'Bloggers Platform'])
            ->setTo([$user->getEmail() => 'A name'])
            ->setBody($message_content)
        ;
        $result = $mailer->send($message);
    }

}