<?php

namespace Fast\Language\Providers;

use Fast\Language\Commands\SyncOldDataCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SyncOldDataCommand::class,
            ]);
        }
    }
}
