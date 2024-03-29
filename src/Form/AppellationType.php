<?php

namespace App\Form;

use App\Entity\Appellation;
use App\Entity\Region;
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
            ->add('name', null, [
                'label' => "form.name",
                'required' => true,
                'attr' => ['autofocus' => true]

            ])
            ->add('region', EntityType::class, [
                'label' => "form.region",
                'class' => Region::class,
                'required' => true,
                'choice_label' => 'name',
                'multiple' => false,
                'query_builder' => fn(RegionRepository $regionRepository) => $regionRepository->myFindAllRegionBuilder()
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Appellation::class,
        ]);
    }
}
