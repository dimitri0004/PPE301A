<?php

namespace App\Form;

use App\Entity\ClasseSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasseSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('classe',EntityType::class,
        [
            "class"=>Classe::class,
            "choice_label"=>"libelle",
            "label"=>'Classe'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClasseSearch::class,
        ]);
    }
}
