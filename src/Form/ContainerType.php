<?php

namespace App\Form;

use App\Entity\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContainerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => "form.name",
                'required' => true,
                'attr' => ['autofocus' => true]
            ])
            ->add('capacity', null, [
                'label' => "form.capacity",
                'required' => true

            ])
            ->add('unit', null, [
                'label' => "form.unit",
                'required' => true

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Container::class
        ]);
    }
}
