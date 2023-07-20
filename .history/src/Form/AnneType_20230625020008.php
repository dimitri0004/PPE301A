<?php

namespace App\Form;

use App\Entity\Anne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code')
            ->add('anne', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy',
                'years' => range(2022, date('Y')),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Anne::class,
        ]);
    }
}
