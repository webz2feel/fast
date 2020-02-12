<?php

namespace Fast\DevTool\Providers;

use Illuminate\Support\ServiceProvider;
use Fast\Base\Traits\LoadAndPublishDataTrait;

class DevToolServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot()
    {
        $this->setNamespace('packages/dev-tool');

        $this->app->register(CommandServiceProvider::class);
    }
}
