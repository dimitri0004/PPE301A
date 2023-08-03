<?php

namespace App\Form;

use App\Entity\Anne;
use App\Entity\Note;


use App\Entity\Eleve;
use App\Entity\Classe;
use App\Entity\Matiere;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeEvaluation', TextType::class,[
                'label'=>"Type Evaluation*"
            ])
            ->add('note', NumberType::class,[
                'label'=>"Note*"
            ])
            ->add('Trimestre', IntegerType::class,[
                'label'=>"Type Evaluation*"
            ])
            ->add('Coefficient', IntegerType::class,[
                'label'=>"Coefficient*"
            ])
           
           
            ->add('Matiere',EntityType::class,
            [
                "class"=>Matiere::class,
                "choice_label"=>"libelle",
                "label"=>'Matiere*'
            ])
            ->add('classe',  EntityType::class,
            [
                "class"=>Classe::class,
                "choice_label"=>"libelle",
                "label"=>'Matiere*',
                'placeholder' => 'Sélectionnez une classe',
            ])
    
            ->add('anne',  EntityType::class,
            [
                "class"=>Anne::class,
                "choice_label"=>"code",
                "label"=>'Annee*',
                'placeholder' => 'Sélectionnez une classe',
            ])
            ->add('eleve', ChoiceType::class, [
                'choices' => [], // Les options des élèves seront chargées dynamiquement via AJAX
                'label' => 'Élève*',
                'choice_label' => 'nom',
                'attr' => [
                    'class' => 'select-eleve'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
            'classes' => [],
            'annes' => [],
        ]);
    }
}
