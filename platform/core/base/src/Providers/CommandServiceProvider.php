<?php

namespace Fast\Base\Providers;

use Fast\Base\Commands\ClearLogCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            ClearLogCommand::class,
        ]);
    }
}
