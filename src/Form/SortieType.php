<?php

namespace App\Form;

use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lesClass = "inputInscription form-control ";
        $builder
            ->add('nom', null, [
                "label" => "Nom"
                , 'attr' => ['class' => $lesClass]
            ])
            ->add('datedebut', DateType::class, [
                "label" => "Date de début"
                , 'attr' => ['class' => $lesClass]
                , 'widget' => 'choice'
                , 'input'  => 'datetime',
            ])
            ->add('duree', TimeType::class, [
                "label" => "Durée"
                , 'attr' => ['class' => $lesClass]
                , 'widget' => 'choice'
                , 'input'  => 'datetime',
            ])
            ->add('datecloture', DateType::class, [
                "label" => "Date de fin"
                , 'attr' => ['class' => $lesClass]
                , 'widget' => 'choice'
                , 'input'  => 'datetime',
            ])
            ->add('nbinscriptionsmax', IntegerType::class, [
                "label" => "Nombre d'inscription max"
                , 'attr' => ['class' => 'tinymce']
            ])
            ->add('descriptioninfos', null, [
                "label" => "Description"
                , 'attr' => ['class' => $lesClass]
            ])
            ->add('campus', null, [
                "label" => "Campus"
                , 'attr' => ['class' => $lesClass]
            ])
            ->add('etat', null, [
                "label" => "Etat"
                , 'attr' => ['class' => $lesClass]
            ])
            ->add('lieu', null, [
                "label" => "Lieu"
                , 'attr' => ['class' => $lesClass]
            ])
            ->add('submit', SubmitType::class, ['label'=>'Confirmer', 'attr'=>['class'=>$lesClass."btn-success"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
