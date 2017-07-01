<?php
    namespace ClientBundle\Form;

    use ClientBundle\Entity\Csv;
    use Symfony\Bridge\Doctrine\Form\Type\EntityType;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\Component\Form\Extension\Core\Type\FileType;
/**
 * Created by PhpStorm.
 * User: matth
 * Date: 29/03/2017
 * Time: 14:09
 */

    class CsvType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder
                ->add('csv', FileType::class, array('label' => 'Utilisateurs (fichier CSV)'))
            ;
        }

        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults(array(
                'data_class' => Csv::class,
            ));
        }
    }