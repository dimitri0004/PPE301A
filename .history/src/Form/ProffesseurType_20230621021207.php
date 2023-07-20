<?php

namespace App\Form;

use App\Entity\Proffesseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProffesseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('fonction')
            ->add('username')
            ->add('confirmPassword')
            ->add('nom')
            ->add('prenom')
            ->add('date_naissance')
            ->add('lieu_naissance')
            ->add('numero')
            ->add('adress')
            ->add('domaine')
            ->add('diplome')
            ->add('sexe')
            ->add('description')
            ->add('security')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Proffesseur::class,
        ]);
    }
}
