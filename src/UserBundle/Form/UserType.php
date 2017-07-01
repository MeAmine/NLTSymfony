<?php

namespace UserBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\User;

/**
 * Created by PhpStorm.
 * User: matth
 * Date: 16/06/2017
 * Time: 10:59
 */

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userName', TextType::class, array('label' => 'Pseudo de l\'utilisateur'))
            ->add('email', EmailType::class, array('label' => 'email de l\'utilisateur'))
            ->add('nom', TextType::class, array('label' => 'Nom de l\'utilisateur'))
            ->add('prenom', TextType::class, array('label' => 'Prénom de l\'utilisateur'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}