<?php

namespace App\Form;

use App\Entity\Campus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CampusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lesClass = "inputInscription form-control ";
        $builder
        ->add('nom_campus', null, [
            "label" => "Nom"
            , 'attr' => ['class' => $lesClass]
        ])
            ->add('submit', SubmitType::class, ['label'=>'Confirmer', 'attr'=>['class'=>$lesClass."btn-success"]])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Campus::class,
        ]);
    }
}
