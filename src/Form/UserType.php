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
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', TextType::class)
            ->add('email', EmailType::class)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('_password', RepeatedType::class)
            ->add('requestedRole', CheckboxType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data-class' => User::class
        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }

}