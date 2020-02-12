<?php

namespace Fast\PluginGenerator\Providers;

use Illuminate\Support\ServiceProvider;

class PluginGeneratorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->register(CommandServiceProvider::class);
    }
}
