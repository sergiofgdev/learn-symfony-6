<?php

namespace App\Controller;

use App\Entity\VinylMix;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MixController extends AbstractController
{
    #[Route('mix/new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $mix = new VinylMix();
        $mix->setTitle('Do you remember... Phil Collins?');
        $mix->setDescription('Do you remember... Phil Collins?');
        $mix->setTrackCount(rand(5,20));
        $mix->setVotes(rand(-50,50));

        $entityManager->persist($mix); //tells Doctrine to be aware of this object
        $entityManager->flush(); //save it on the db

        return new Response(sprintf(
            'Mix %d is %d tracks of pure 80 heaven',
            $mix->getId(),
            $mix->gettrackCount()
        ));
    }
}