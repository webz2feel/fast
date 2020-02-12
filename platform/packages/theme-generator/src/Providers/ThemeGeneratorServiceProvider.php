<?php

namespace Fast\ThemeGenerator\Providers;

use Illuminate\Support\ServiceProvider;
use Fast\Base\Traits\LoadAndPublishDataTrait;

class ThemeGeneratorServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot()
    {
        $this->app->register(CommandServiceProvider::class);
    }
}
