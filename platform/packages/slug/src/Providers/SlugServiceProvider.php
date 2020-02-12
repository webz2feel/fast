<?php

namespace Fast\Slug\Providers;

use Fast\Base\Supports\Helper;
use Fast\Base\Traits\LoadAndPublishDataTrait;
use Fast\Slug\Models\Slug;
use Fast\Slug\Repositories\Caches\SlugCacheDecorator;
use Fast\Slug\Repositories\Eloquent\SlugRepository;
use Fast\Slug\Repositories\Interfaces\SlugInterface;
use Illuminate\Support\ServiceProvider;

class SlugServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(SlugInterface::class, function () {
            return new SlugCacheDecorator(new SlugRepository(new Slug));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('packages/slug')
            ->loadAndPublishConfigurations(['general'])
            ->loadAndPublishViews()
            ->loadRoutes(['web'])
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        $this->app->register(FormServiceProvider::class);
        $this->app->register(HookServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);
    }
}
