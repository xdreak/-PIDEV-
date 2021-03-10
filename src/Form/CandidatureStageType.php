<?php

namespace App\Form;

use App\Entity\CandidatureStage;
use App\Entity\OffreStage;
use Doctrine\ORM\Mapping\Entity;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatureStageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom')
            ->add('Prenom')
            ->add('Email')
            ->add('Age')
            ->add('id_stage' , EntityType::class,[
                    'class'=>OffreStage::class,
                    'choice_label'=>'Stage_id',
                    'disabled'=> true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CandidatureStage::class,
        ]);
    }
}
