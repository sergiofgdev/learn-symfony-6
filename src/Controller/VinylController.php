<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function Symfony\Component\String\u;

class VinylController
{

    #[Route('/')]
    public function homepage() : Response
    {
        return new Response("I am Sergio");
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