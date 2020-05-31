<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Region;
use App\Repository\ContainerRepository;
use App\Repository\CountryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => "form.name",
                'attr' => ['autofocus' => true]
            ])
            ->add('country', EntityType::class, [
                'label' => "form.country",
                'class' => Country::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => false,
                'query_builder' => function (CountryRepository $countryRepository) {
                    return $countryRepository->myFindAllCountryBuilder();
                }
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Region::class,

        ]);
    }

//    private function getChoices()
//    {
//        $choices = Region::COUNTRY;
//        $output = [];
//        foreach ($choices as $k => $v) {
//            $output[$v] = $k;
//        }
//        return $output;
//    }
}
