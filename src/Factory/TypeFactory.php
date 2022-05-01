<?php

namespace App\Factory;

use App\Entity\Type;
use App\Repository\TypeRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Type>
 *
 * @method static Type|Proxy createOne(array $attributes = [])
 * @method static Type[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Type|Proxy find(object|array|mixed $criteria)
 * @method static Type|Proxy findOrCreate(array $attributes)
 * @method static Type|Proxy first(string $sortedField = 'id')
 * @method static Type|Proxy last(string $sortedField = 'id')
 * @method static Type|Proxy random(array $attributes = [])
 * @method static Type|Proxy randomOrCreate(array $attributes = [])
 * @method static Type[]|Proxy[] all()
 * @method static Type[]|Proxy[] findBy(array $attributes)
 * @method static Type[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Type[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static TypeRepository|RepositoryProxy repository()
 * @method Type|Proxy create(array|callable $attributes = [])
 */
final class TypeFactory extends ModelFactory
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
            // ->afterInstantiate(function(Type $type): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Type::class;
    }
}
