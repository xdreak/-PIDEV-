<?php

namespace App\Form;

use App\Entity\Demande;
use App\Entity\Offre;
use App\Entity\Quiz;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Title')
            ->add('Ville')
            ->add('Domain')
            ->add('CompanyName')
            ->add('Salaire')
            ->add('Type')
            ->add('Description')
            ->add('Test', EntityType::class,[
                'class'=>Quiz::class,
                'empty_data'  => null,
                'choice_label'=>'id',
                'required'    => false,


            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);

        $resolver->setDefaults([
            'attr' => [
                'novalidate' => 'novalidate', // comment me to reactivate the html5 validation!  🚥
            ]
        ]);
    }
}
