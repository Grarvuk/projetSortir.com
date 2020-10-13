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

class SortieAnnuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $lesClass = "inputInscription form-control ";
        $builder
            ->add('messageAnnulation', null, [
                "label" => "Raison de l'annulation"
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
