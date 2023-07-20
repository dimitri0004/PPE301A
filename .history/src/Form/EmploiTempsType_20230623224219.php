<?php

namespace App\Form;

use App\Entity\Salle;
use App\Entity\Classe;
use App\Entity\Matiere;
use App\Entity\EmploiTemps;
use App\Entity\Proffesseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class EmploiTempsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jour',ChoiceType::class,[
                'choices' => [    
                    'Lundi' => 'Lundi',
                    'Mardi' => 'Mardi',
                    'Mercredi' => 'Mercredi',
                    'Jeudi' => 'Jeudi',
                    'Vendredi' => 'Vendredi',
                    'Samedi' => 'Samedi',
                    
                    // Ajoutez d'autres pays selon vos besoins
                ],
                'label' => 'Jour',
                'required' => true,
            ])
            
            ->add('heure_debut', TimeType::class, [
                'label' => 'Heure de début',
                'input' => 'datetime',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ]])

            ->add('heure_fin', TimeType::class, [
                'label' => 'Heure de Fin',
                'input' => 'datetime',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ]]) 

            ->add('matiere',EntityType::class,
            [
                "class"=>Matiere::class,
                "choice_label"=>"libelle",
                "label"=>'Matiere'
            ])
            ->add('professeur',EntityType::class,
            [
                "class"=>Proffesseur::class,
                "choice_label"=>"libelle",
                "label"=>'Proffesseur'
            ])
            ->add('classe',EntityType::class,
            [
                "class"=>Classe::class,
                "choice_label"=>"libelle",
                "label"=>'Salle'
            ])
            ->add('salle',EntityType::class,
            [
                "class"=>Salle::class,
                "choice_label"=>"libelle",
                "label"=>''
            ])

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EmploiTemps::class,
        ]);
    }
}
