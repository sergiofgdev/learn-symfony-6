<?php

namespace App\Factory;

use App\Entity\VinylMix;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<VinylMix>
 */
final class VinylMixFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return VinylMix::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'createdAt' => self::faker()->dateTime(),
            'genre' => self::faker()->randomElement(['Pop','Rock']),
//            'slug' => self::faker()->text(10),
            'title' => self::faker()->text(25),
            'trackCount' => self::faker()->randomNumber(),
            'updatedAt' => self::faker()->dateTime(),
            'votes' => self::faker()->randomNumber(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(VinylMix $vinylMix): void {})
        ;
    }
}
