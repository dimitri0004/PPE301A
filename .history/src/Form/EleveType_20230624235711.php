<?php

namespace App\Form;

use App\Entity\Eleve;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EleveType extends AbstractType
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
            ->add('annee',EntityType::class,
            [
                "class"=>Classe::class,
                "choice_label"=>"libelle",
                "label"=>'Annee Inscription'
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

            ->add('Adress', TextareaType::class , [
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
            'data_class' => Directeur::class,
        ]);
    }
}
