<?php

namespace Fast\PluginManagement\Providers;

use Fast\PluginManagement\Commands\PluginActivateCommand;
use Fast\PluginManagement\Commands\PluginAssetsPublishCommand;
use Fast\PluginManagement\Commands\PluginDeactivateCommand;
use Fast\PluginManagement\Commands\PluginRemoveCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PluginAssetsPublishCommand::class,
            ]);
        }

        $this->commands([
            PluginActivateCommand::class,
            PluginDeactivateCommand::class,
            PluginRemoveCommand::class,
        ]);
    }
}
