<?php

namespace App\DataFixtures;

use App\Factory\MarketFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MarketFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        MarketFactory::createMany(3);
    }
}
