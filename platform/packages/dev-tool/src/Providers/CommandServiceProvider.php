<?php

namespace Fast\DevTool\Providers;

use Fast\DevTool\Commands\InstallCommand;
use Fast\DevTool\Commands\LocaleCreateCommand;
use Fast\DevTool\Commands\LocaleRemoveCommand;
use Fast\DevTool\Commands\Make\ControllerMakeCommand;
use Fast\DevTool\Commands\Make\FormMakeCommand;
use Fast\DevTool\Commands\Make\ModelMakeCommand;
use Fast\DevTool\Commands\Make\RepositoryMakeCommand;
use Fast\DevTool\Commands\Make\RequestMakeCommand;
use Fast\DevTool\Commands\Make\RouteMakeCommand;
use Fast\DevTool\Commands\Make\TableMakeCommand;
use Fast\DevTool\Commands\PackageCreateCommand;
use Fast\DevTool\Commands\RebuildPermissionsCommand;
use Fast\DevTool\Commands\TestSendMailCommand;
use Fast\DevTool\Commands\TruncateTablesCommand;
use Fast\DevTool\Commands\UserCreateCommand;
use Fast\DevTool\Commands\PackageMakeCrudCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                TableMakeCommand::class,
                ControllerMakeCommand::class,
                RouteMakeCommand::class,
                RequestMakeCommand::class,
                FormMakeCommand::class,
                ModelMakeCommand::class,
                RepositoryMakeCommand::class,
                PackageCreateCommand::class,
                PackageMakeCrudCommand::class,
                InstallCommand::class,
                TestSendMailCommand::class,
                TruncateTablesCommand::class,
                UserCreateCommand::class,
                RebuildPermissionsCommand::class,
                LocaleRemoveCommand::class,
                LocaleCreateCommand::class,
            ]);
        }
    }
}
