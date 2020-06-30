<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('password', PasswordType::class)
            ->add('confirm_password', PasswordType::class)
            ->add('file' , FileType::class,array(
                'label' => 'Upload photo ',
                'mapped' => false,
                'attr' => array(
                    'placeholder' => 'uploader votre photo',
                    'required'=> 'false',
                    'style' => 'margin-top:1em; margin-bottom:1em;', 
                    'class'=>'btn btn-small waves-effect waves-light'
                   
                )
                
    
           ))
               
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
