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
