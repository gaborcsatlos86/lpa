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
        $admin->setEmail('gabor.csatlos86@gmail.com');
        $admin->setUsername('web-admin');
        $admin->setName('Web Admin');
        $admin->setPlainPassword('DemoLogin678');
        $admin->setEnabled(true);
        $admin->setSuperAdmin(true)
        ;
        $manager->persist($admin);
        
        $admin2 = new User();
        $admin2->setEmail('info@csabainformatika.net');
        $admin2->setName('LPA Admin');
        $admin2->setUsername('lpa-admin');
        $admin2->setPlainPassword('DemoLogin678');
        $admin2->setEnabled(true);
        $admin2->setSuperAdmin(true)
        ;
        $manager->persist($admin2);

        $manager->flush();
    }
}
