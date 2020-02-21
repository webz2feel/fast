<?php

namespace Fast\RequestLog\Providers;

use Fast\Base\Events\SessionStarted;
use Fast\Base\Supports\Helper;
use Fast\Base\Traits\LoadAndPublishDataTrait;
use Fast\Support\Services\Cache\Cache;
use Fast\RequestLog\Repositories\Caches\RequestLogCacheDecorator;
use Fast\RequestLog\Repositories\Eloquent\RequestLogRepository;
use Fast\RequestLog\Repositories\Interfaces\RequestLogInterface;
use Event;
use Illuminate\Support\ServiceProvider;
use Fast\RequestLog\Models\RequestLog as RequestLogModel;

/**
 * Class RequestLogServiceProvider
 * @package Fast\RequestLog
 * @author Imran Ali
 * @since 02/07/2016 09:50 AM
 */
class RequestLogServiceProvider extends ServiceProvider
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
        if (setting('enable_cache', false)) {
            $this->app->singleton(RequestLogInterface::class, function () {
                return new RequestLogCacheDecorator(new RequestLogRepository(new RequestLogModel()), new Cache($this->app['cache'], RequestLogRepository::class));
            });
        } else {
            $this->app->singleton(RequestLogInterface::class, function () {
                return new RequestLogRepository(new RequestLogModel());
            });
        }

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    /**
     * Boot the service provider.
     * @author Imran Ali
     */
    public function boot()
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);

        $this->setIsInConsole($this->app->runningInConsole())
            ->setNamespace('plugins/request-log')
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->publishPublicFolder()
            ->publishAssetsFolder();

        $this->app->register(HookServiceProvider::class);

        Event::listen(SessionStarted::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id' => 'cms-plugin-request-log',
                    'priority' => 8,
                    'parent_id' => 'cms-core-platform-administration',
                    'name' => trans('plugins.request-log::request-log.name'),
                    'icon' => null,
                    'url' => route('request-log.list'),
                    'permissions' => ['request-log.list'],
                ]);
        });
    }
}
