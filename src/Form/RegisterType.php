<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lesClass = "inputInscription form-control ";
        $builder
            ->add("pseudo", null, [
                "label" => "Pseudo"
                , 'attr' => ['class' => $lesClass]
            ])
            ->add("nom", null, [
                "label" => "Nom"
                , 'attr' => ['class' => $lesClass]
            ])
            ->add("prenom", null, [
                "label" => "Prénom"
                , 'attr' => ['class' => $lesClass]
            ])
            ->add("telephone", null, [
                "label" => "Téléphone"
                , 'attr' => ['class' => $lesClass]
            ])
            ->add("mail", EmailType::Class, [
                "label" => "mail"
                , 'attr' => ['class' => $lesClass]
            ])
            ->add("campus", null, [
                "label" => "Campus"
                , 'attr' => ['class' => $lesClass]
            ])
            ->add("mot_de_passe", RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe n\'a pas été correctement réécris.',
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe', 'attr' => ['class' => $lesClass]],
                'second_options' => ['label' => 'Réécrire le mot de passe', 'attr' => ['class' => $lesClass]],
            ], [
                "label" => "Mot de passe"
            ])
            ->add('submit', SubmitType::class, ['label'=>'Confirmer', 'attr'=>['class'=>$lesClass."btn-success"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}