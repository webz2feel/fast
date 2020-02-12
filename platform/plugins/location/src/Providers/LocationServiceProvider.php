<?php

namespace Fast\Location\Providers;

use Fast\Location\Models\City;
use Fast\Location\Repositories\Caches\CityCacheDecorator;
use Fast\Location\Repositories\Eloquent\CityRepository;
use Fast\Location\Repositories\Interfaces\CityInterface;
use Fast\Location\Models\Country;
use Fast\Location\Repositories\Caches\CountryCacheDecorator;
use Fast\Location\Repositories\Eloquent\CountryRepository;
use Fast\Location\Repositories\Interfaces\CountryInterface;
use Fast\Location\Models\State;
use Fast\Location\Repositories\Caches\StateCacheDecorator;
use Fast\Location\Repositories\Eloquent\StateRepository;
use Fast\Location\Repositories\Interfaces\StateInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Fast\Base\Supports\Helper;
use Event;
use Fast\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;
use Language;

class LocationServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * @var Application
     */
    protected $app;

    public function register()
    {
        $this->app->bind(CountryInterface::class, function () {
            return new CountryCacheDecorator(new CountryRepository(new Country));
        });

        $this->app->bind(StateInterface::class, function () {
            return new StateCacheDecorator(new StateRepository(new State));
        });

        $this->app->bind(CityInterface::class, function () {
            return new CityCacheDecorator(new CityRepository(new City));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/location')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
            Language::registerModule([
                Country::class,
                State::class,
                City::class,
            ]);
        }

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-plugins-location',
                    'priority'    => 5,
                    'parent_id'   => null,
                    'name'        => 'plugins/location::location.name',
                    'icon'        => 'fas fa-globe',
                    'url'         => null,
                    'permissions' => ['country.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-country',
                    'priority'    => 0,
                    'parent_id'   => 'cms-plugins-location',
                    'name'        => 'plugins/location::country.name',
                    'icon'        => null,
                    'url'         => route('country.index'),
                    'permissions' => ['country.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-state',
                    'priority'    => 1,
                    'parent_id'   => 'cms-plugins-location',
                    'name'        => 'plugins/location::state.name',
                    'icon'        => null,
                    'url'         => route('state.index'),
                    'permissions' => ['state.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-city',
                    'priority'    => 2,
                    'parent_id'   => 'cms-plugins-location',
                    'name'        => 'plugins/location::city.name',
                    'icon'        => null,
                    'url'         => route('city.index'),
                    'permissions' => ['city.index'],
                ]);
        });
    }
}
