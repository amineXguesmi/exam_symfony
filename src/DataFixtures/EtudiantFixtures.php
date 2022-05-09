<?php

namespace App\DataFixtures;

use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
class EtudiantFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $repository=$manager->getRepository(Section::class);
        $faker=Factory::create('fr_FR');
        for ($i=0;$i<40;$i++) {
            $e = new \App\Entity\Etudiant();
            $e->setNom($faker->name);
            $e->setPrenom($faker->firstName);
            $repo=$manager->getRepository(Section::class);
            $rand=rand(1,100);
            if($i%2==0){
            $s=$repo->find($rand);
            $e->setSection($s);}
            $manager->persist($e);
        }
        $manager->flush();
    }
}
