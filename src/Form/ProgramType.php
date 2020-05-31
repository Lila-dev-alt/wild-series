<?php

namespace App\Form;

use App\Entity\Program;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Actor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null,  ['label' => 'Titre'])
            ->add('summary', null, ['label' => 'Résumé',
                'attr' => [
                    'rows' => 5,
                ]] )
            ->add('poster', null, ['label' => 'Image'])
            ->add('country', null, ['label' => 'Pays de diffusion'])
            ->add('year', null, ['label' => 'Année'])
            ->add('category', null, ['choice_label' => 'name', 'label' => 'Catégorie'])
            ->add('actors', EntityType::class, [
                'class' => Actor::class,
                'choice_label' => 'name',
                'label' => 'Acteurs',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,

            ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
