<?php

namespace App\Form;

use App\Entity\Appellation;
use App\Entity\Grape;
use App\Entity\Wine;
use App\Entity\WineSearch;
use App\Repository\AppellationRepository;
use App\Repository\GrapeRepository;
use App\Repository\WineRepository;
use Doctrine\DBAL\Types\StringType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('minYear', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Année minimale'
                ]
            ])
            ->add('maxPrice', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Budget max'
                ]
            ])
            ->add('grapes', EntityType::class, [
                'required' => false,
                'label' => "Cépages",
                'class' => Grape::class,
                'choice_label' => 'name',
                'multiple' => true,
                'query_builder' => function (GrapeRepository $grapeRepository) {
                    return $grapeRepository->myFindAllBuilder();
                }
            ])
            ->add('appellation', EntityType::class, [
                'required' => false,
                'placeholder' => 'Appellation',
                'label' => false,
                'class' => Appellation::class,
                'choice_label' => 'name',
                'multiple' => false,
                'query_builder' => function (AppellationRepository $appellation) {
                    return $appellation->myFindAllAppelBuilder();
                }
            ])
            ->add('color', ChoiceType::class, [
                "choices" => array_combine(Wine::COLOR, Wine::COLOR),
                'placeholder' => 'Couleur',
                'required' => false,
                'label' => false,
            ])
            ->add('name', TextType::class, [
                "required" => false,
                "label" => "Nom",
            ])

        ;
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
