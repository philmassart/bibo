<?php

namespace App\Form;

use App\Entity\Appellation;
use App\Entity\Container;
use App\Entity\Grape;
use App\Entity\Wine;
use App\Repository\AppellationRepository;
use App\Repository\ContainerRepository;
use App\Repository\GrapeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('year')
            ->add('alcohol')
            ->add('color', ChoiceType::class,[
                'choices' => $this->getChoices()
            ])
            ->add('grapes', EntityType::class, [
                'class' => Grape::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => true,
                'query_builder' => function(GrapeRepository $grapeRepository)
                {
                    return $grapeRepository->myFindAllBuilder();
                }
            ])
            ->add('appellation', EntityType::class, [
                'class' => Appellation::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => false,
                'query_builder' => function(AppellationRepository $appellationRepository)
                {
                    return $appellationRepository->myFindAllAppelBuilder();
                }
            ])
            ->add('container', EntityType::class, [
                'class' => Container::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => false,
                'query_builder' => function(ContainerRepository $containerRepository)
                {
                    return $containerRepository->myFindAllContainerBuilder();
                }
            ])
            ->add('stock')
            ->add('price')
            ->add('imageFile', FileType::class, [
                'required' => false
            ])
        ;
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Wine::class,
            'translation_domain' => 'forms'
        ]);
    }

    private function getChoices()
    {
        $choices = Wine::COLOR;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
}
