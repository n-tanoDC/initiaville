<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $nicolas = new User();
        $nicolas->setFirstname('Nicolas');
        $nicolas->setLastname('Tano');
        $nicolas->setEmail('nicolas@gmail.com');
        $nicolas->setPassword($this->passwordEncoder->encodePassword($nicolas, 'password'));
        $nicolas->setRoles(['ROLE_ADMIN']);
        $this->addReference('user-nicolas', $nicolas);
        $manager->persist($nicolas);

        $jean = new User();
        $jean->setFirstname('Jean');
        $jean->setLastname('Dupont');
        $jean->setEmail('jean@gmail.com');
        $jean->setPassword($this->passwordEncoder->encodePassword($jean, 'password'));
        $this->addReference('user-jean', $jean);
        $manager->persist($jean);
        
        $manager->flush();
    }
}
