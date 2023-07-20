<?php

namespace App\Form;

use App\Entity\Salle;
use App\Entity\Classe;
use App\Entity\EmploiTemps;
use App\Entity\Matiere;
use App\Entity\Proffesseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmploiTempsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jour')
            ->add('heure_debut')
            ->add('heure_fin') 
            ->add('matiere',EntityType::class,
            [
                "class"=>Matiere::class,
                "choice_label"=>"email",
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
