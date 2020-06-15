<?php

namespace App\Form;

use App\Entity\Figure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditFigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom', null,array(
                'label' => 'Nom ',
                'attr' => array(
                    'placeholder' => 'Nom de la figure'
                )
           ))

           ->add('Description', null,array(
            'label' => 'Description ',
            'attr' => array(
                'placeholder' => 'Description de la figure'
            )
       ))
            
           
            ->add('GroupeFigure',  null,array(
                'label' => 'Groupe de figure ',
                'attr' => array(
                    'placeholder' => 'Groupe de figure'
                )
           ))
            ->add('lienVideo',  null,array(
                'label' => 'lien de la vidéo ',
                'attr' => array(
                    'placeholder' => 'lien de votre vidéo'
                )
           ))
            ->add('lienPhoto' , null,array(
                'label' => 'lien de la photo ',
                'attr' => array(
                    'placeholder' => 'lien de votre photo'
                )
                

           ))
            //->add('userId')
            //->add('user')
            ->setMethod('post')
           
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }
}
