<?php

namespace Fast\PluginGenerator\Providers;

use Fast\PluginGenerator\Commands\PluginCreateCommand;
use Fast\PluginGenerator\Commands\PluginListCommand;
use Fast\PluginGenerator\Commands\PluginMakeCrudCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PluginListCommand::class,
                PluginCreateCommand::class,
                PluginMakeCrudCommand::class,
            ]);
        }
    }
}
