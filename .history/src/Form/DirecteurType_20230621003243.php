<?php

namespace App\Form;

use App\Entity\Directeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DirecteurType extends RegistrationFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
            $builder
            ->remove('type')
            ->remove('fonction')
            ->remove('agreeTerms')
            ->remove('confirmPassword')
            ->add('security',PasswordType::class, [
                'constraints' => [
                    new EqualTo([
                        'propertyPath' => 'password',
                        'message' => 'Les valeurs du password et de security doivent être identiques.',
                    ]),
                ],
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom*',
                'required'=> true,
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prenom*',
                'required'=> true,
            ])
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Masculin' => 'Masculin',
                    'Feminin' =>  'Feminin',
                    
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('dateNaissance', DateType::class, [
                'label' => 'Date Naissance*',
                'required'=> true,
                'html5' => false,
            ])
            ->add('lieuNaissance', TextType::class, [
                'label' => 'Lieu Naissance*',
                'required'=> true,
            ])
            ->add('numero',TextType::class, [
                'label' => 'Numero*',
                'required'=> true,
            ])
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
