<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('Amélie');
        $user->setPassword('$2y$13$3UcH7A/kNTZQBuzmoijBQ.4QBBiY5DWy1BFdaaupz4vd6QBa.E2oS');

        $manager->persist($user);

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword('$2y$13$7s6EzEoiOOVslvlJA9AYq.hqWpKVitimVgoz0TnEowBDvesoAXPaK');
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $manager->flush();
    }
}
