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
           
            ->add('eleve' ,EntityType::class,
            [
                "class"=>Eleve::class,
                "choice_label"=>"email",
                "label"=>'Eleve*'
            ])
            ->add('Matiere',EntityType::class,
            [
                "class"=>Matiere::class,
                "choice_label"=>"libelle",
                "label"=>'Matiere*'
            ])
            ->add('classe', ChoiceType::class, [
                'label' => 'Classe*',
                'choices' => $options['classes'],
                'choice_label' => function (Classe $classe) {
                    return $classe->getLibelle();
                },
                'placeholder' => 'Sélectionnez une classe',
            ])
    
            ->add('anne', ChoiceType::class, [
                'label' => 'Année*',
                'choices' => $options['annes'],
                'choice_label' => function (Anne $classe) {
                    return $classe->getCode();
                },
                'placeholder' => 'Sélectionnez une Anne',
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();
    
                // Récupérer la classe et l'année sélectionnées
                $classe = $data['classe'];
                $annee = $data['anne'];
    
                // Mettre à jour les options du champ "eleve" en fonction de la classe et de l'année
                $form->add('eleve', EntityType::class, [
                    'class' => Eleve::class,
                    'choice_label' => 'email',
                    'label' => 'Eleve*',
                    'query_builder' => function (EntityRepository $repository) use ($classe, $annee) {
                        return $repository->createQueryBuilder('eleve')
                            ->join('eleve.classe', 'classe')
                            ->join('classe.annee', 'anne')
                            ->where('classe.id = :classeId')
                            ->andWhere('anne.id = :anneId')
                            ->setParameter('classeId', $classe)
                            ->setParameter('anneId', $annee);
                    },
                ]);
            });
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
