<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'email' => 'simon.clement.pierre.daniel@gmail.com',
            'username' => 'clement',
            'roles' => ['ROLE_USER'],
        ]);
        UserFactory::createOne([
            'email' => 'admin@admin.fr',
            'username' => 'admin',
            'roles' => ['ROLE_ADMIN'],
        ]);
        UserFactory::createOne([
            'email' => 'superadmin@admin.fr',
            'username' => 'superadmin',
            'roles' => ['ROLE_SUPER_ADMIN'],
        ]);
        UserFactory::createMany(2);
    }
}
