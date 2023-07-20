<?php

namespace App\Form;

use App\Entity\Note;
use App\Entity\Matiere;
use Doctrine\DBAL\Types\TextType;
use Doctrine\DBAL\Types\BigIntType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeEvaluation', TextType::class,[
                'label'=>"Type Evaluation*"
            ])
            ->add('note', IntegerType::class,[
                'label'=>"Note*"
            ])
            ->add('Trimestre', IntegerType::class,[
                'label'=>"Type Evaluation*"
            ])
            ->add('Coefficient', IntegerType::class,[
                'label'=>"Type Evaluation*"
            ])
            ->add('Mention', TextType::class,[
                'label'=>"Type Evaluation*"
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
