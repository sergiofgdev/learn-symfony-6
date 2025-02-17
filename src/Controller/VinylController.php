<?php

namespace App\Controller;

use App\Entity\VinylMix;
use App\Repository\VinylMixRepository;
use App\Service\MixRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

class VinylController extends AbstractController
{

    public function __construct(
        private bool                   $isDebug,
        private MixRepository          $mixRepository,
        private EntityManagerInterface $entityManager,
        private VinylMixRepository     $VinylMixRepository,

    )
    {
    }

    #[Route('/', name: 'app_homepage')]
    public function homepage(): Response
    {
        $tracks = [
            ['song' => 'Gangsta\'s Paradise', 'artist' => 'Coolio'],
            ['song' => 'Waterfalls', 'artist' => 'TLC'],
            ['song' => 'Creep', 'artist' => 'Radiohead'],
            ['song' => 'Kiss from a Rose', 'artist' => 'Seal'],
            ['song' => 'On Bended Knee', 'artist' => 'Boyz II Men'],
            ['song' => 'Fantasy', 'artist' => 'Mariah Carey'],
        ];

        return $this->render('vinyl/homepage.html.twig', [
            'title' => 'PB & Jams',
            'tracks' => $tracks,
        ]);
    }

    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(Request $request, ?string $slug = null): Response
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;

        //EntityManagerInterface
//        $mixRepository = $this->entityManager->getRepository(VinylMix::class);
//        $mixes = $mixRepository->findAll();
//        $mixes = $this->mixRepository->findAll();

        //VinylMixRepository como Servicio
//        $mixes = $this->VinylMixRepository->findAll();
//        $mixes = $this->VinylMixRepository->findAllOrderedByVotes($slug);


        //En vez de mostrar todos, vamos a meter paginization con pagerfanta bundle
        $queryBuilder = $this->VinylMixRepository->createOrderedByVotesQueryBuilder($slug);
        $adapter = new QueryAdapter($queryBuilder);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->getInt('page', 1),
            9
        );

//        dd($pagerfanta);
        return $this->render('vinyl/browse.html.twig', [
            'genre' => $genre,
            'pagerfanta' => $pagerfanta,
//            'mixes' => $mixes
        ]);
    }
}
