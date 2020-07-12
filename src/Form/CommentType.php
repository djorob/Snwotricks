<?php

namespace App\Form;

use App\Entity\Forum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('content',TextareaType::class,array(
                'label' => 'contenu ',
                'attr' => array(
                    'placeholder' => 'votre contenu',
                    'style' => 'margin-top:1em; margin-bottom:1em;',
                    'style' => 'margin-left:2em; margin-right:2em', 
                    
                )
           ))
          

         /*  ->add('createdAt', null,array(
            'label' => 'crée le  ',
            'attr' => array(
                'placeholder' => 'crée a '
            )
       ))*/
       
       ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Forum::class,
        ]);
    }
}
