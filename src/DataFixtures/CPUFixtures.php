<?php

namespace App\DataFixtures;

use App\Entity\CPU;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CPUFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $cpu = new CPU; 
            $cpu->setName("CPU $i");
            $cpu->setDescription("i9");
            $cpu->setImage("cpu.jpg");
            $manager->persist($cpu);
        }
        $manager->flush();
    }
}
