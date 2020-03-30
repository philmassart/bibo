<?php

namespace App\Form;

use App\Entity\Appellation;
use App\Entity\Region;
use App\Repository\AppellationRepository;
use App\Repository\RegionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppellationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => false,
                'query_builder' => function(RegionRepository $regionRepository)
                {
                    return $regionRepository->myFindAllRegionBuilder();
                }
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Appellation::class,
            'translation_domain' => 'forms'

        ]);
    }
}