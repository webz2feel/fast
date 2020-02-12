<?php

namespace Fast\Theme\Providers;

use Fast\Base\Supports\Helper;
use Fast\Theme\Commands\ThemeAssetsPublishCommand;
use Fast\Theme\Commands\ThemeAssetsRemoveCommand;
use Fast\Base\Traits\LoadAndPublishDataTrait;
use Fast\Theme\Commands\ThemeActivateCommand;
use Fast\Theme\Commands\ThemeRemoveCommand;
use Fast\Theme\Contracts\Theme as ThemeContract;
use Fast\Theme\Facades\ThemeFacade;
use Fast\Theme\Http\Middleware\AdminBarMiddleware;
use Fast\Theme\Theme;
use Event;
use File;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Schema;

class ThemeServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        /**
         * @var Router $router
         */
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', AdminBarMiddleware::class);

        Helper::autoload(__DIR__ . '/../../helpers');

        $this->app->bind(ThemeContract::class, Theme::class);

        $this->commands([
            ThemeActivateCommand::class,
            ThemeRemoveCommand::class,
            ThemeAssetsPublishCommand::class,
            ThemeAssetsRemoveCommand::class,
        ]);
    }

    public function boot()
    {
        $this->setNamespace('packages/theme')
            ->loadAndPublishConfigurations(['general', 'permissions'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->loadRoutes(['web'])
            ->publishAssets();

        $this->app->register(HookServiceProvider::class);

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-core-appearance',
                    'priority'    => 996,
                    'parent_id'   => null,
                    'name'        => 'core/base::layouts.appearance',
                    'icon'        => 'fa fa-paint-brush',
                    'url'         => '#',
                    'permissions' => [],
                ])
                ->registerItem([
                    'id'          => 'cms-core-theme',
                    'priority'    => 1,
                    'parent_id'   => 'cms-core-appearance',
                    'name'        => 'packages/theme::theme.name',
                    'icon'        => null,
                    'url'         => route('theme.index'),
                    'permissions' => ['theme.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-core-theme-option',
                    'priority'    => 4,
                    'parent_id'   => 'cms-core-appearance',
                    'name'        => 'packages/theme::theme.theme_options',
                    'icon'        => null,
                    'url'         => route('theme.options'),
                    'permissions' => ['theme.options'],
                ])
                ->registerItem([
                    'id'          => 'cms-core-appearance-custom-css',
                    'priority'    => 5,
                    'parent_id'   => 'cms-core-appearance',
                    'name'        => 'packages/theme::theme.custom_css',
                    'icon'        => null,
                    'url'         => route('theme.custom-css'),
                    'permissions' => ['theme.custom-css'],
                ]);

            admin_bar()->registerLink('Theme', route('theme.index'), 'appearance');
        });

        $this->app->booted(function () {
            $file = public_path(config('packages.theme.general.themeDir') . '/' . setting('theme') . '/css/style.integration.css');
            if (File::exists($file)) {
                ThemeFacade::getFacadeRoot()
                    ->asset()
                    ->container('after_header')
                    ->add('theme-style-integration-css',
                        config('packages.theme.general.themeDir') . '/' . setting('theme') . '/css/style.integration.css');
            }

            if (!setting('theme')) {
                setting()->set('theme', Arr::first(scan_folder(theme_path())));
            }
        });

        $this->app->register(ThemeManagementServiceProvider::class);
    }
}
