<?php

namespace App\Form;

use App\Entity\OffreStage;
use App\Entity\Quiz;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Quiz2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('r1')

            ->add('r2')

            ->add('r3')

            ->add('r4')

            ->add('r5')
            ->add('Id_StageQ' , EntityType::class,[
                'class'=>OffreStage::class,
                'choice_label'=>'Stage_id',
                'disabled'=> true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
        ]);
    }
}
