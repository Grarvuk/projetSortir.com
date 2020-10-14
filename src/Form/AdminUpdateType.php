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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdminUpdateType extends AbstractType
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
            ->add("administrateur", ChoiceType::class, [
                'choices' => [
                    'Yes' => true,
                    'No' => false
                ],
                 'label' => 'Administrateur ?'
            ])
            ->add("actif", ChoiceType::class, [
                'choices' => [
                    'Yes' => true,
                    'No' => false
                ],
                 'label' => 'Actif ?'
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
