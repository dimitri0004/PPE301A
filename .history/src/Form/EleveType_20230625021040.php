<?php

namespace App\Form;

use App\Entity\Anne;
use App\Entity\Eleve;
use App\Entity\Classe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EleveType extends RegistrationFormType
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
                    new NotBlank(), 
                ],
                'mapped' => false,
                'label'=>'Confirme Password'
            ])
            ->add('classe',EntityType::class,
            [
                "class"=>Classe::class,
                "choice_label"=>"libelle",
                "label"=>'Classe'
            ])
            ->add('anne',EntityType::class,
            [
                "class"=>Anne::class,
                "choice_label"=>"anne",
                "label"=>'Annee Inscription',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy',
                'years' => range(2022, date('Y')),
            ])
            
            ->add('prenom', TextType::class, [
                'label' => 'Prenom*',
                'required'=> true,
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

            ->add('Adress', TextType::class , [
                'label' => 'Adress*',
                'required'=> true,
            ])
            
            ->add('description', TextareaType::class , [
                'label' => 'Description*',
                'required'=> true,
            ])


            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
        ]);
    }
}
