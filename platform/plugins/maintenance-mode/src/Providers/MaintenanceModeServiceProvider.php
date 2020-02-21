<?php

namespace Fast\MaintenanceMode\Providers;

use Illuminate\Support\ServiceProvider;
use Fast\Base\Supports\Helper;
use Fast\Base\Events\SessionStarted;
use Event;
use Fast\Base\Traits\LoadAndPublishDataTrait;

class MaintenanceModeServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @author Imran Ali
     */
    public function register()
    {
        Helper::autoload(__DIR__ . '/../../helpers');
    }

    /**
     * @author Imran Ali
     */
    public function boot()
    {
        $this->setIsInConsole($this->app->runningInConsole())
            ->setNamespace('plugins/maintenance-mode')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->publishPublicFolder()
            ->publishAssetsFolder();

        Event::listen(SessionStarted::class, function () {
            dashboard_menu()->registerItem([
                'id' => 'cms-core-system-maintenance-mode',
                'priority' => 700,
                'parent_id' => 'cms-core-platform-administration',
                'name' => trans('plugins.maintenance-mode::maintenance-mode.maintenance_mode'),
                'icon' => null,
                'url' => route('system.maintenance.index'),
                'permissions' => ['superuser'],
            ]);
        });
    }
}
