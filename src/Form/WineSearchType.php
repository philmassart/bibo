<?php

namespace App\Form;

use App\Entity\Appellation;
use App\Entity\Feature;
use App\Entity\Grape;
use App\Entity\Pairing;
use App\Entity\Wine;
use App\Entity\WineSearch;
use App\Repository\AppellationRepository;
use App\Repository\FeatureRepository;
use App\Repository\GrapeRepository;
use App\Repository\PairingRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WineSearchType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isStock', CheckboxType::class, [
                'label' => "En stock",
                'label_attr' => ['class' => 'switch-custom'],
                'attr' => [
                    'id' => "inStock"
                ],
                'required' => false

            ])
            ->add('minYear', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Année minimale',
                    'class' => 'myfield'
                ]
            ])
            ->add('maxPrice', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Budget max',
                    'class' => 'myfield'
                ]
            ])
            ->add('grapes', EntityType::class, [
                'required' => false,
                'placeholder' => 'Cépages',
                'empty_data' => 'Cépages',
                'label' => false,
                'class' => Grape::class,
                'choice_label' => 'name',
                'multiple' => true,
                'attr' => [
                    'class' => 'myfield'
                ],
                'query_builder' => function (GrapeRepository $grapeRepository) {
                    return $grapeRepository->myFindAllBuilder();
                }
            ])
            ->add('appellation', EntityType::class, [
                'required' => false,
                'placeholder' => '(toutes)',
                'label' => 'Appellation',
                'class' => Appellation::class,
                'choice_label' => 'name',
                'multiple' => false,
                'attr' => [
                    'class' => 'myfield'
                ],
                'query_builder' => function (AppellationRepository $appellation) {
                    return $appellation->myFindAllAppelBuilder();
                },
                'group_by' => function (Appellation $appellation) {
                    return $appellation->getRegion()->getName();
                },

            ])
            ->add('color', ChoiceType::class, [
                "choices" => array_combine(Wine::COLOR, Wine::COLOR),
                'placeholder' => '(toutes)',
                'required' => false,
                'label' => 'Couleur',
                'attr' => [
                    'class' => 'myfield'
                ],

            ])
            ->add('winegrowing', ChoiceType::class, [
                "choices" => array_combine(Wine::WINEGROWING, Wine::WINEGROWING),
                'placeholder' => '(toutes)',
                'required' => false,
                'label' => 'Viticulture',
                'attr' => [
                    'class' => 'myfield'
                ],

            ])
            ->add('features', EntityType::class, [
                'required' => false,
                'label' => "Caractéristiques",
                'class' => Feature::class,
                'choice_label' => 'name',
                'multiple' => true,
                'attr' => [
                    'class' => 'myfield'
                ],
                'query_builder' => function (FeatureRepository $featureRepository) {
                    return $featureRepository->myFindAllBuilder();
                }
            ])
            ->add('pairings', EntityType::class, [
                'required' => false,
                'label' => "Associations",
                'class' => Pairing::class,
                'choice_label' => 'name',
                'multiple' => true,
                'attr' => [
                    'class' => 'myfield'
                ],
                'query_builder' => function (PairingRepository $pairingRepository) {
                    return $pairingRepository->myFindAllBuilder();
                }
            ])
            ->add('name', TextType::class, [
                "required" => false,
                "label" => false,
                'attr' => [
                    'class' => 'myfield'
                ]

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WineSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
}
