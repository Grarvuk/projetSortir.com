<?php

namespace App\Form;

use App\Entity\Lieu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lesClass = "inputInscription form-control ";
        $builder
            ->add('nom_lieu', null, [
                "label" => "Nom"
                , 'attr' => ['class' => $lesClass]
            ])
            ->add('rue', null, [
                "label" => "Rue"
                , 'attr' => ['class' => $lesClass]
            ])
            ->add('latitude', null, [
                "label" => "Latitude"
                , 'attr' => ['class' => $lesClass]
            ])
            ->add('longitude', null, [
                "label" => "Longitude"
                , 'attr' => ['class' => $lesClass]
            ])
            ->add('ville', null, [
                "label" => "Ville"
                , 'attr' => ['class' => $lesClass]
            ])
            ->add('submit', SubmitType::class, ['label'=>'Confirmer', 'attr'=>['class'=>$lesClass."btn-success"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
