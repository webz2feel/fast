<?php

namespace Fast\ThemeGenerator\Providers;

use Fast\ThemeGenerator\Commands\ThemeCreateCommand;
use Fast\ThemeGenerator\Commands\ThemeInstallSampleDataCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ThemeCreateCommand::class,
            ]);
        }

        $this->commands([
            ThemeInstallSampleDataCommand::class,
        ]);
    }
}
