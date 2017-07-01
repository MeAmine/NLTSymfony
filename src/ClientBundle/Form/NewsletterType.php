<?php
namespace ClientBundle\Form;

use ClientBundle\Entity\Newsletter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Created by PhpStorm.
 * User: matth
 * Date: 12/06/2017
 * Time: 09:21
 */

class NewsletterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Titre'))
            ->add('template', TextareaType::class, array('label' => 'Template'))
            ->add('description', TextareaType::class, array('label' => 'Description de la newsletter'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Newsletter::class,
        ));
    }
}