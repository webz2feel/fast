<?php

namespace Fast\WidgetGenerator\Providers;

use Fast\WidgetGenerator\Commands\WidgetCreateCommand;
use Fast\WidgetGenerator\Commands\WidgetRemoveCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                WidgetCreateCommand::class,
                WidgetRemoveCommand::class,
            ]);
        }
    }
}
