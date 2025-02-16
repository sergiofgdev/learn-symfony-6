<?php

namespace App\Service;

use Psr\Cache\CacheItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MixRepository
{

    private $httpClient;
    private $cache;

    public function __construct(HttpClientInterface $httpClient, CacheInterface $cache, ){
        $this->httpClient = $httpClient;
        $this->cache = $cache;
    }
    public function findAll()
    {
        $mixes = $this->cache->get('mixes_data', function (CacheItemInterface $cacheItem)  {
            $cacheItem->expiresAfter(5);
            $response = $this->httpClient->request('GET', 'https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/refs/heads/main/mixes.json');
            return $response->toArray();
        });

        return $mixes;

    }
}