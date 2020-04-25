<?php

namespace App\Form;

use App\Entity\Appellation;
use App\Entity\Container;
use App\Entity\Feature;
use App\Entity\Grape;
use App\Entity\Pairing;
use App\Entity\Wine;
use App\Repository\AppellationRepository;
use App\Repository\ContainerRepository;
use App\Repository\FeatureRepository;
use App\Repository\GrapeRepository;
use App\Repository\PairingRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class WineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => "form.name",
                'attr' => ['autofocus' => true]
            ])
            ->add('description', null, [
                'label' => "form.description"
            ])
            ->add('year', null, [
                'label' => "form.year",
                'required' => false,
            ])
            ->add('alcohol', null, [
                'label' => "form.alcohol"
            ])
            ->add('color', ChoiceType::class, [
                'label' => "form.color",
                'choices' => Wine::COLOR
            ])
            ->add('winegrowing', ChoiceType::class, [
                'label' => "form.winegrowing",
                'choices' => Wine::WINEGROWING
            ])
            ->add('features', EntityType::class, [
                'label' => "form.features",
                'class' => Feature::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => true,
                'query_builder' => function (FeatureRepository $featureRepository) {
                    return $featureRepository->myFindAllBuilder();
                }
            ])
            ->add('pairings', EntityType::class, [
                'label' => "form.pairings",
                'class' => Pairing::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => true,
                'query_builder' => function (PairingRepository $pairingRepository) {
                    return $pairingRepository->myFindAllBuilder();
                }
            ])
            ->add('grapes', EntityType::class, [
                'label' => "form.grapes",
                'class' => Grape::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => true,
                'query_builder' => function (GrapeRepository $grapeRepository) {
                    return $grapeRepository->myFindAllBuilder();
                }
            ])
            ->add('appellation', EntityType::class, [
                'label' => "form.appellation",
                'class' => Appellation::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => false,
                'query_builder' => function (AppellationRepository $appellationRepository) {
                    return $appellationRepository->myFindAllAppelBuilder();
                }
            ])
            ->add('container', EntityType::class, [
                'label' => "form.container",
                'class' => Container::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => false,
                'query_builder' => function (ContainerRepository $containerRepository) {
                    return $containerRepository->myFindAllContainerBuilder();
                }
            ])
            ->add('stock', null, [
                'label' => "form.stock"
            ])
            ->add('nbbottle', null, [
                'label' => "form.nbbottle"
            ])
            ->add('price', null, [
                'label' => "form.price"
            ])
            ->add('location', null, [
                'label' => "form.location"
            ])
            ->add('imageFile', VichFileType::class, [
                'label' => "form.imagefile",
                'required' => false
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Wine::class,
        ]);
    }
}
