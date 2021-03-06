<?php

namespace Fast\Translation\Providers;

use Illuminate\Routing\Events\RouteMatched;
use Fast\Base\Traits\LoadAndPublishDataTrait;
use Fast\Translation\Console\CleanCommand;
use Fast\Translation\Console\ExportCommand;
use Fast\Translation\Console\FindCommand;
use Fast\Translation\Console\ImportCommand;
use Fast\Translation\Console\ResetCommand;
use Fast\Translation\Manager;
use Event;
use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind('translation-manager', Manager::class);

        $this->commands([
            ImportCommand::class,
            FindCommand::class,
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                ResetCommand::class,
                ExportCommand::class,
                CleanCommand::class,
            ]);
        }
    }

    public function boot()
    {
        $this->setNamespace('plugins/translation')
            ->loadAndPublishConfigurations(['general', 'permissions'])
            ->loadMigrations()
            ->loadRoutes(['web'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-plugin-translation',
                'priority'    => 6,
                'parent_id'   => 'cms-core-platform-administration',
                'name'        => 'plugins/translation::translation.menu_name',
                'icon'        => null,
                'url'         => route('translations.index'),
                'permissions' => ['translations.index'],
            ]);
        });
    }
}
