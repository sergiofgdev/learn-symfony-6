<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function Symfony\Component\String\u;

class VinylController extends AbstractController
{

    #[Route('/')]
    public function homepage() : Response
    {
        $tracks = [
            ['song' => 'Gangs Paradise', 'artist' => 'Coolio'],
            ['song' => 'Waterfalls', 'artist' => 'TLC'],
            ['song' => 'Creep', 'artist' => 'Radiohead'],
            ['song' => 'Kiss from a Rose', 'artist' => 'Seal'],
            ['song' => 'On bended knee', 'artist' => 'Boyz II Men'],
            ['song' => 'Fantasy', 'artist' => 'Mariah Carey']
        ];

//        return new Response("I am Sergio");
        //extends AbstractController me permite acceder a render() el cual devuelve un Response
        return $this->render('/vinyl/homepage.html.twig',[
            'title' => 'Homepage',
            'tracks' => $tracks
        ]);
    }

    #[Route('/browse/{slug}')]
    public function browse(string $slug = null ) : Response
    {
        $title = "All genres";
        if ($slug) {
            $title = 'Genre: ' . u(str_replace("-", " ", $slug))->title(true);
        }
        return new Response($title);
    }

}