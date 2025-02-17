<?php

namespace App\DataFixtures;

use App\Entity\VinylMix;
use App\Factory\VinylMixFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
//        $mix = new VinylMix();
//        $mix->setTitle('Do you remember... Phil Collins?');
//        $mix->setDescription('Do you remember... Phil Collins?');
//        $genres = ['pop', 'rock'];
//        $mix->setGenre($genres[array_rand($genres)]);
//        $mix->setTrackCount(rand(5, 20));
//        $mix->setVotes(rand(-50, 50));
//
//        //Persist & flush
//        $manager->persist($mix);
//        $manager->flush();

        //Igual que en laravel
//        VinylMixFactory::createOne();
        VinylMixFactory::createMany(10);
    }
}
