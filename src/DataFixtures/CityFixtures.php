<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $laval = new City();
        $laval->setName('Laval');
        $laval->setPicture('laval.jpg');
        $this->addReference('city-laval', $laval);
        $manager->persist($laval);

        $rennes = new City();
        $rennes->setName('Rennes');
        $rennes->setPicture('rennes.jpg');
        $this->addReference('city-rennes', $rennes);
        $manager->persist($rennes);

        $stmalo = new City();
        $stmalo->setName('St-Malo');
        $stmalo->setPicture('st-malo.jpg');
        $this->addReference('city-st-malo', $stmalo);
        $manager->persist($stmalo);

        $vannes = new City();
        $vannes->setName('Vannes');
        $vannes->setPicture('vannes.jpg');
        $this->addReference('city-vannes', $vannes);
        $manager->persist($vannes);

        $manager->flush();
    }
}
