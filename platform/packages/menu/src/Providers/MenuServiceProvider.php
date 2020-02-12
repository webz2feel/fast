<?php

namespace Fast\Menu\Providers;

use Fast\Base\Supports\Helper;
use Fast\Base\Traits\LoadAndPublishDataTrait;
use Fast\Menu\Models\Menu as MenuModel;
use Fast\Menu\Models\MenuLocation;
use Fast\Menu\Models\MenuNode;
use Fast\Menu\Repositories\Caches\MenuCacheDecorator;
use Fast\Menu\Repositories\Caches\MenuLocationCacheDecorator;
use Fast\Menu\Repositories\Caches\MenuNodeCacheDecorator;
use Fast\Menu\Repositories\Eloquent\MenuLocationRepository;
use Fast\Menu\Repositories\Eloquent\MenuNodeRepository;
use Fast\Menu\Repositories\Eloquent\MenuRepository;
use Fast\Menu\Repositories\Interfaces\MenuInterface;
use Fast\Menu\Repositories\Interfaces\MenuLocationInterface;
use Fast\Menu\Repositories\Interfaces\MenuNodeInterface;
use Event;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->app->bind(MenuInterface::class, function () {
            return new MenuCacheDecorator(
                new MenuRepository(new MenuModel)
            );
        });

        $this->app->bind(MenuNodeInterface::class, function () {
            return new MenuNodeCacheDecorator(
                new MenuNodeRepository(new MenuNode)
            );
        });

        $this->app->bind(MenuLocationInterface::class, function () {
            return new MenuLocationCacheDecorator(
                new MenuLocationRepository(new MenuLocation)
            );
        });

        $this->setNamespace('packages/menu')
            ->loadAndPublishConfigurations(['permissions', 'general'])
            ->loadRoutes(['web'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-core-menu',
                    'priority'    => 2,
                    'parent_id'   => 'cms-core-appearance',
                    'name'        => 'core/base::layouts.menu',
                    'icon'        => null,
                    'url'         => route('menus.index'),
                    'permissions' => ['menus.index'],
                ]);

            if (!defined('THEME_MODULE_SCREEN_NAME')) {
                dashboard_menu()
                    ->registerItem([
                        'id'          => 'cms-core-appearance',
                        'priority'    => 996,
                        'parent_id'   => null,
                        'name'        => 'core/base::layouts.appearance',
                        'icon'        => 'fa fa-paint-brush',
                        'url'         => '#',
                        'permissions' => [],
                    ]);
            }

            if (function_exists('admin_bar')) {
                admin_bar()->registerLink('Menu', route('menus.index'), 'appearance');
            }
        });
    }
}
