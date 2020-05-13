<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $ecologie = new Category();
        $ecologie->setLabel('Ecologie');
        $this->addReference('cat-ecologie', $ecologie);
        $manager->persist($ecologie);

        $loisir = new Category();
        $loisir->setLabel('Loisir');
        $this->addReference('cat-loisir', $loisir);
        $manager->persist($loisir);

        $sante = new Category();
        $sante->setLabel('Santé');
        $this->addReference('cat-sante', $sante);
        $manager->persist($sante);

        $manager->flush();
    }
}
