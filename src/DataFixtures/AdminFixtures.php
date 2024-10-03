<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class AdminFixtures extends Fixture
{
    
    public function load(ObjectManager $manager): void
    {
        /** @var User $admin */
        $admin = new User();
        $admin->setEmail('csatlos.gabor86@gmail.com');
        $admin->setUsername('web-admin');
        $admin->setPlainPassword('DemoLogin678');
        $admin->setEnabled(true);
        $admin->setSuperAdmin(true)
        ;
        $manager->persist($admin);

        $manager->flush();
    }
}
