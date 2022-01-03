<?php

namespace App\DataFixtures;

use App\Entity\Laptop;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class LaptopFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $laptop = new Laptop; 
            $laptop->setName("Laptop $i");
            $laptop->setMadein("China");
            $laptop->setPrice("2000");
            $laptop->setPriceDiscount("20");
            $laptop->setImage("lap.jpg");
            $manager->persist($laptop);
        }
        $manager->flush();
    }
}
