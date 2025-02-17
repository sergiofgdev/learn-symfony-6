<?php

namespace App\Service;

use Psr\Cache\CacheItemInterface;
use Symfony\Bridge\Twig\Command\DebugCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MixRepository
{

//YA NO USO ESTE SERVICIO CREADO PERO LO DEJO COMO EJEMPLO
    public function __construct(
        private HttpClientInterface $githubContentClient,
        private CacheInterface      $cache,
        #[Autowire('$kernel.debug%')]
        private bool                $isDebug,
        #[Autowire(service: 'twig.command.debug')]
        private DebugCommand        $twigDebugCommand,
    )
    {

    }

    public function findAll()
    {

//        $output = new BufferedOutput();
//        $this->twigDebugCommand->run(new ArrayInput([]), $output);
//        dd($output);


        return $this->cache->get('mixes_data', function (CacheItemInterface $cacheItem) {
            $cacheItem->expiresAfter($this->isDebug ? 5 : 60);
            $response = $this->githubContentClient->request('GET', '/SymfonyCasts/vinyl-mixes/refs/heads/main/mixes.json');
            return $response->toArray();
        });

    }
}