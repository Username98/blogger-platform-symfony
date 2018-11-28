<?php
/**
 * Created by PhpStorm.
 * User: stas.pivchenko
 * Date: 11/27/18
 * Time: 11:46 PM
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username')
            ->add('_password', PasswordType::class);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}