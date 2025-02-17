<?php

namespace App\Controller;

use App\Entity\VinylMix;
use App\Repository\VinylMixRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MixController extends AbstractController
{

    public function __construct(
        private VinylMixRepository     $VinylMixRepository,
        private EntityManagerInterface $entityManager
    )
    {
    }

    #[Route('mix/new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $mix = new VinylMix();
        $mix->setTitle('Do you remember... Phil Collins?');
        $mix->setDescription('Do you remember... Phil Collins?');
        $genres = ['pop', 'rock'];
        $mix->setGenre($genres[array_rand($genres)]);
        $mix->setTrackCount(rand(5, 20));
        $mix->setVotes(rand(-50, 50));

        $entityManager->persist($mix); //tells Doctrine to be aware of this object
        $entityManager->flush(); //save the objets Doctrine is being aware of in the DB

        return new Response(sprintf(
            'Mix %d is %d tracks of pure 80 heaven',
            $mix->getId(),
            $mix->gettrackCount()
        ));
    }

    #[Route('/mix/{id}', name: 'app_mix_show')]
    public function show(VinylMix $mix)
    {
        //Esto no es necesario si pasamos como argumento VinylMix, es util cuando necesitamos un simple objeto, siempre
        //que el wildcard coincida con lo que hay en la bd, en este caso id
//        $mix = $this->VinylMixRepository->find($id);
//
//        if(!$mix){
//            throw $this->createNotFoundException('Mix not found');
//        }


//        dd($mix);
        return $this->render('mix/show.html.twig', [
            'mix' => $mix
        ]);
    }


    #[Route('mix/{id}/vote', name: 'app_mix_vote', methods: ['POST'])]
    public function vote(VinylMix $mix, Request $request): Response
    {
        $miReq = $request;
//        dd($miReq);

        $direction = $request->request->get('direction', 'up');
        if ($direction == 'up') {
            $mix->upVote();
        } else {
            $mix->downVote();
        }
        $this->entityManager->flush(); //Doctrine guarda los objetos
        $this->addFlash('success','Vote counted');
        return $this->redirectToRoute('app_mix_show', ['id' => $mix->getId()]);
    }
}