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
            ->add('classe',  ChoiceType::class, [
                'label' => 'Classe*',
                'choices' => $options['classes'],
                'choice_label' => function (Classe $classe) {
                    return $classe->getLibelle();
                },
                'placeholder' => 'Sélectionnez une classe',
            ])
    
            ->add('anne',  ChoiceType::class, [
                'label' => 'Classe*',
                'choices' => $options['annes'],
                'choice_label' => function (Anne $classe) {
                    return $classe->getCode();
                },
                'placeholder' => 'Sélectionnez une classe',
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();
            
                if ($data === null) {
                    return;
                }
            
                // Récupérer la classe et l'année sélectionnées
                $annee = $data->getAnne();
                $classe = $data->getClasse();
            
                // Mettre à jour les options du champ "eleve" en fonction de la classe et de l'année
                $form->add('eleve', EntityType::class, [
                    'class' => Eleve::class,
                    'choice_label' => 'email',
                    'label' => 'Eleve*',
                    'query_builder' => function (EntityRepository $repository) use ($data) {
                        $classe = $data->getClasse();
                        $annee = $data->getCode();
                        
                        if ($classe !== null && $annee !== null) {
                            return $repository->createQueryBuilder('eleve')
                                ->join('eleve.classe', 'classe')
                                ->join('classe.anne', 'anne')
                                ->where('classe.id = :classeId')
                                ->andWhere('anne.id = :anneId')
                                ->setParameter('classeId', $classe->getId())
                                ->setParameter('anneId', $annee->getId());
                        } else {
                            // Retourner une requête vide si la classe ou l'année est nulle
                            return $repository->createQueryBuilder('eleve')
                                ->where('1 = 0');
                        }
                    },
                ]);
            });
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
