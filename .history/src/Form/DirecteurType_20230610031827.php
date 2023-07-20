<?php

namespace App\Form;

use App\Entity\Directeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DirecteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email',EmailType::class)
            ->add('dateNaissance', DateType::class)
            ->add('lieuNaissance', TextType::class, [
                'label' => 'Lieu Naissance*',
                'required'=> true,
            ])
            ->add('numero')
            ->add('diplome', ChoiceType::class, [
                'choices' => [
                    'BTS' => 'BTS',
                    'License' => 'License',
                    'Master' => 'Master',
                    'Doctorat' => 'Doctorat',
                    // Ajoutez d'autres pays selon vos besoins
                ],
                'label' => 'Diplome*',
                'required' => true,
            ])
            ->add('Domaine', TextType::class, [
                'label' => 'Domaine*',
                'required'=> true,
            ])
            ->add('Description', TextareaType::class , [
                'label' => 'Description*',
                'required'=> true,
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Directeur::class,
        ]);
    }
}
