<?php

namespace Fast\Revision\Providers;

use Fast\Base\Supports\Helper;
use Fast\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Support\ServiceProvider;

class RevisionServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('packages/revision')
            ->loadAndPublishViews()
            ->loadAndPublishConfigurations(['general'])
            ->loadMigrations()
            ->publishAssets();

        $this->app->register(HookServiceProvider::class);
    }
}
