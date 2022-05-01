<?php

namespace App\DataFixtures;

use App\Factory\RangeFactory;
use App\Factory\BoardGameFactory;
use App\Factory\VideoFactory;
use App\Factory\ImageFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BoardGameFixtures extends Fixture
{
    public function load(ObjectManager $manager):void
    {
        $range = RangeFactory::createOne();

        BoardGameFactory::createMany(5, [
            'gamme' => $range,
        ]);

        $board = BoardGameFactory::createOne();

        $video = VideoFactory::createOne(['boardGame' => $board]);

        $image = ImageFactory::createOne(['isFirst' => 1, 'boardGame' => $board]);
    }
}
