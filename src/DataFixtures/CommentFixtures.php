<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $com1 = new Comment();
        $com1->setTitle("C'est une super idée !");
        $com1->setContent("J'aimerais vraiment pouvoir participer avec vous à ce projet.");
        $com1->setCreatedAt(new \DateTime('2020-05-12 10:00:00'));
        $com1->setUser($this->getReference('user-nicolas'));
        $com1->setProject($this->getReference('project-potager'));
        $manager->persist($com1);

        $com2 = new Comment();
        $com2->setTitle("Avec des ruches !");
        $com2->setContent("On pourrait également installer des ruches sur le toit. Cela permettrait d'améliorer la bio-diversité et contribuerait au bon développement du potager. Il faudrait peut-être d'autres insectes nécessaires permettant de combattre les nuisibles (pucerons, limaces...).");
        $com2->setCreatedAt(new \DateTime('2020-05-01 20:41:56'));
        $com2->setUser($this->getReference('user-jean'));
        $com2->setProject($this->getReference('project-potager'));
        $manager->persist($com2);

        $manager->flush();
    }


    public function getDependencies()
    {
        return [
          UserFixtures::class,
          ProjectFixtures::class
        ];
    }
}
