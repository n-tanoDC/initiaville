<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $potager = new Project();
        $potager->setTitle('Potager sur les toits');
        $potager->setPicture('potager-toit.jpg');
        $potager->setCost(75000);
        $potager->setExcerpt('Aménager des potagers sur les toits de la ville.');
        $potager->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci architecto, corporis enim inventore iure laudantium minus nam odio officia quae quasi quia repellat reprehenderit, tempora tempore, temporibus ullam ut voluptates.');
        $potager->setCreatedAt(new \DateTime());
        $potager->setCity($this->getReference('city-rennes'));
        $potager->setUser($this->getReference('user-nicolas'));
        $potager->addCategory($this->getReference('cat-ecologie'));
        $this->addReference('project-potager', $potager);
        $manager->persist($potager);

        $boiteALire = new Project();
        $boiteALire->setTitle('Boîte à lire');
        $boiteALire->setPicture('boite-a-lire.jpg');
        $boiteALire->setCost(3000);
        $boiteALire->setExcerpt('Permettre l\'échange de livre entre particuliers.');
        $boiteALire->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci architecto, corporis enim inventore iure laudantium minus nam odio officia quae quasi quia repellat reprehenderit, tempora tempore, temporibus ullam ut voluptates.');
        $boiteALire->setCreatedAt(new \DateTime());
        $boiteALire->setCity($this->getReference('city-rennes'));
        $boiteALire->setUser($this->getReference('user-jean'));
        $boiteALire->addCategory($this->getReference('cat-loisir'));
        $this->addReference('project-boite-a-lire', $boiteALire);
        $manager->persist($boiteALire);

        $cinema = new Project();
        $cinema->setTitle('Cinéma en plein air');
        $cinema->setPicture('cinema-plein-air.jpg');
        $cinema->setCost(25000);
        $cinema->setExcerpt('Proposer des séances de cinéma en plein air 2 soirs par semaine.');
        $cinema->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci architecto, corporis enim inventore iure laudantium minus nam odio officia quae quasi quia repellat reprehenderit, tempora tempore, temporibus ullam ut voluptates.');
        $cinema->setCreatedAt(new \DateTime());
        $cinema->setCity($this->getReference('city-st-malo'));
        $cinema->setUser($this->getReference('user-nicolas'));
        $cinema->addCategory($this->getReference('cat-loisir'));
        $this->addReference('project-cinema', $cinema);
        $manager->persist($cinema);

        $manager->flush();
    }


    public function getDependencies()
    {
        return [
          CityFixtures::class,
          CategoryFixtures::class,
          UserFixtures::class
        ];
    }
}
