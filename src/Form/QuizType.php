<?php

namespace App\Form;

use App\Entity\Offre;
use App\Entity\Quiz;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Q1')
            ->add('R1')
            ->add('Q2')
            ->add('R2')
            ->add('Q3')
            ->add('R3')
            ->add('Q4')
            ->add('R4')
            ->add('Q5')
            ->add('R5')
            ->add('finder', EntityType::class,[
                'class'=>Offre::class,
                'choice_label'=>'Title',

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
        ]);

        $resolver->setDefaults([
            'attr' => [
                'novalidate' => 'novalidate', // comment me to reactivate the html5 validation!  🚥
            ]
        ]);
    }
}
