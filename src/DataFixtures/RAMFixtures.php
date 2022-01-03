<?php

namespace App\DataFixtures;

use App\Entity\RAM;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class RAMFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            
            $ram = new RAM; 
            $ram->setName("RAM $i");
            $ram->setDescription("$i GB");
            $manager->persist($ram);
        }
        $manager->flush();
    }
}
