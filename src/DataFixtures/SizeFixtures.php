<?php

namespace App\DataFixtures;

use App\Entity\Size;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SizeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=10; $i++) {
            $size = new Size; 
            $size ->setName("size ");
            $size ->setDescription("400 px");
            $manager->persist($size);
        }
        $manager->flush();
    }
}
