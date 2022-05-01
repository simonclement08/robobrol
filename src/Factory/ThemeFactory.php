<?php

namespace App\Factory;

use App\Entity\Theme;
use App\Repository\ThemeRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Theme>
 *
 * @method static Theme|Proxy createOne(array $attributes = [])
 * @method static Theme[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Theme|Proxy find(object|array|mixed $criteria)
 * @method static Theme|Proxy findOrCreate(array $attributes)
 * @method static Theme|Proxy first(string $sortedField = 'id')
 * @method static Theme|Proxy last(string $sortedField = 'id')
 * @method static Theme|Proxy random(array $attributes = [])
 * @method static Theme|Proxy randomOrCreate(array $attributes = [])
 * @method static Theme[]|Proxy[] all()
 * @method static Theme[]|Proxy[] findBy(array $attributes)
 * @method static Theme[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Theme[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ThemeRepository|RepositoryProxy repository()
 * @method Theme|Proxy create(array|callable $attributes = [])
 */
final class ThemeFactory extends ModelFactory
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
            // ->afterInstantiate(function(Theme $theme): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Theme::class;
    }
}
