<?php

namespace App\DataFixtures;

use App\Factory\ThemeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ThemeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ThemeFactory::createMany(5);
    }
}
