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
        $builder
            ->add("pseudo", null, [
                "label" => "Pseudo"
            ])
            ->add("nom", null, [
                "label" => "Nom"
            ])
            ->add("prenom", null, [
                "label" => "Prénom"
            ])
            ->add("telephone", null, [
                "label" => "Téléphone"
            ])
            ->add("mail", EmailType::Class, [
                "label" => "mail"
            ])
            ->add("campus", null, [
                "label" => "Campus"
            ])
            ->add("mot_de_passe", RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe n\'a pas été correctement réécris.',
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Réécrire le mot de passe'],
            ], [
                "label" => "Mot de passe"
            ])
            ->add('submit', SubmitType::class, ['label'=>'Envoyer', 'attr'=>['class'=>'btn-primary btn-block']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
