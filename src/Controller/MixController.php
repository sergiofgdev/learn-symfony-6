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


        return new Response(sprintf(
            'Mix %d is %d tracks of pure 80 heaven',
            $mix->getId(),
            $mix->gettrackCount()
        ));
    }

    #[Route('/mix/{slug}', name: 'app_mix_show')]
    public function show(VinylMix $mix):Response
    {
        //Esto no es necesario si pasamos como argumento VinylMix, es util cuando necesitamos un simple objeto, siempre
        //que el wildcard coincida con lo que hay en la bd, en este caso id
//        $mix = $this->VinylMixRepository->find($id);
//
//        if(!$mix){
//            throw $this->createNotFoundException('Mix not found');
//        }


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
        return $this->redirectToRoute('app_mix_show', ['slug' => $mix->getSlug()]);
    }
}