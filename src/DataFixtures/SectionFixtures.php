<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
class SectionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create('fr_FR');
        for ($i=0;$i<40;$i++) {
            $s = new \App\Entity\Section();
            $s->setDesignation($faker->title);
            $manager->persist($s);
        }
        $manager->flush();
    }
}
