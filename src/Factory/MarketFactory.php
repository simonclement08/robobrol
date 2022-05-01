<?php

namespace App\Factory;

use App\Entity\Market;
use App\Repository\MarketRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Market>
 *
 * @method static Market|Proxy createOne(array $attributes = [])
 * @method static Market[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Market|Proxy find(object|array|mixed $criteria)
 * @method static Market|Proxy findOrCreate(array $attributes)
 * @method static Market|Proxy first(string $sortedField = 'id')
 * @method static Market|Proxy last(string $sortedField = 'id')
 * @method static Market|Proxy random(array $attributes = [])
 * @method static Market|Proxy randomOrCreate(array $attributes = [])
 * @method static Market[]|Proxy[] all()
 * @method static Market[]|Proxy[] findBy(array $attributes)
 * @method static Market[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Market[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static MarketRepository|RepositoryProxy repository()
 * @method Market|Proxy create(array|callable $attributes = [])
 */
final class MarketFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'name' => self::faker()->word(),
            'link' => self::faker()->url(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Market $market): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Market::class;
    }
}
