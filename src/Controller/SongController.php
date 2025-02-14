<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SongController extends AbstractController
{
    #[Route('/api/songs/{id<\d+>}', methods: ['GET'])]
    public function getSong(int $id): Response
    {
        $song = [
            'id' => $id,
            'name' => 'Song 1',
            'url' => 'https://www.google.com/',
        ];

//        return new JsonResponse(($song));
        return $this->json($song);
    }

}