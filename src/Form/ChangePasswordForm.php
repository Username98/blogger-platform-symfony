<?php
/**
 * Created by PhpStorm.
 * User: stas.pivchenko
 * Date: 11/28/18
 * Time: 1:04 AM
 */

namespace App\Form;


use App\Entity\User;
use Symfony\Component\DependencyInjection\Compiler\RepeatedPass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('oldPassword', PasswordType::class);
        $builder->add('newPassword', RepeatedType::class, array(
            'type' => PasswordType::class,
            'invalid_message' => 'The password fields must match.',
            'required' => true,
            'first_options'  => array('label' => 'Password'),
            'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'value' => 'Register',
                    'class' => 'form-control btn btn-register',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data-class' => User::class,
            'allow_extra_fields' => true,
        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }

    public function getName()
    {
        return 'change_passwd';
    }


}