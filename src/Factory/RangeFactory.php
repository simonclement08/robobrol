<?php

namespace App\Factory;

use App\Entity\Range;
use App\Repository\RangeRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Range>
 *
 * @method static Range|Proxy createOne(array $attributes = [])
 * @method static Range[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Range|Proxy find(object|array|mixed $criteria)
 * @method static Range|Proxy findOrCreate(array $attributes)
 * @method static Range|Proxy first(string $sortedField = 'id')
 * @method static Range|Proxy last(string $sortedField = 'id')
 * @method static Range|Proxy random(array $attributes = [])
 * @method static Range|Proxy randomOrCreate(array $attributes = [])
 * @method static Range[]|Proxy[] all()
 * @method static Range[]|Proxy[] findBy(array $attributes)
 * @method static Range[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Range[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static RangeRepository|RepositoryProxy repository()
 * @method Range|Proxy create(array|callable $attributes = [])
 */
final class RangeFactory extends ModelFactory
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
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Range $range): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Range::class;
    }
}
