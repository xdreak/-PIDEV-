<?php

namespace App\Form;

use App\Entity\Event;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('datedebut', DateType::class)
            ->add('datefin', DateType::class)
            ->add('plan', CKEditorType::class)
            ->add('ville',ChoiceType::class,[
                                    'choices' => ['Tunis'=>'Tunis',
                                                  'Ariana'=>'Ariana',
                                                  'Ben Arous'=>'Ben Arous',
                                                  'Manouba'=>'Manouba',
                                                  'Nabeul'=>'Nabeul',
                                                  'Zaghouan'=>'Zaghouan',
                                                  'Bizerte'=>'Bizerte',
                                                  'Beja'=>'Beja',
                                                  'Jendouba'=>'Jendouba',
                                                  'Kef'=>'Kef',
                                                  'Siliana'=>'Siliana',
                                                  'Kairouan'=>'Kairouan',
                                                  'Kasserine'=>'Kasserine',
                                                  'Sidi Bouzid'=>'Sidi Bouzid',
                                                  'Sousse'=>'Sousse',
                                                  'Monastir'=>'Monastir',
                                                  'Mahdia'=>'Mahdia',
                                                  'Sfax'=>'Sfax',
                                                  'Gafsa'=>'Gafsa',
                                                  'Tozeur'=>'Tozeur',
                                                  'Kebili'=>'Kebili',
                                                  'Gabes'=>'Gabes',
                                                  'Médenine'=>'Médenine',
                                                  'Tataouine'=>'Tataouine'
                                  ]])
            ->add('adresse')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
