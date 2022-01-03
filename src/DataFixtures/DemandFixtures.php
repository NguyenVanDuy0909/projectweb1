<?php

namespace App\DataFixtures;

use App\Entity\Demand;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class DemandFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $demand = new Demand; 
            $demand->setName("Demand $i");
            $demand->setDescription("Học");
            $manager->persist($demand);
        }
        $manager->flush();
    }
}
