<?php

namespace App\DataFixtures;

use App\Entity\Wine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class WineFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i=0; $i <100; $i++) {
          $wine = new Wine();
          $wine
            ->setName($faker->words(3, true ))
            ->setDescription($faker->sentences(3, true))
            ->setContent($faker->numberBetween(37, 300))
            ->setPrice($faker->numberBetween(5,50))
            ->setAppellation($faker->words(1, true))
            ->setColor($faker->numberBetween(1, count(Wine::COLOR) - 1))
            ->setCountry($faker->country)
            ->setYear($faker->numberBetween(1990, 2020))
            ->setStock(false)
            ->setRegion($faker->words(1, true));
          $manager->persist($wine);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
