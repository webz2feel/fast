<?php

namespace Fast\Vendor\Providers;

use Fast\Vendor\Models\Package;
use Fast\Vendor\Repositories\Caches\PackageCacheDecorator;
use Fast\Vendor\Repositories\Eloquent\PackageRepository;
use Fast\Vendor\Repositories\Interfaces\PackageInterface;
use Illuminate\Routing\Events\RouteMatched;
use Fast\Base\Supports\Helper;
use Fast\Base\Traits\LoadAndPublishDataTrait;
use Fast\Vendor\Http\Middleware\RedirectIfVendor;
use Fast\Vendor\Http\Middleware\RedirectIfNotVendor;
use Fast\Vendor\Models\Vendor;
use Fast\Vendor\Models\VendorActivityLog;
use Fast\Vendor\Repositories\Caches\VendorActivityLogCacheDecorator;
use Fast\Vendor\Repositories\Caches\VendorCacheDecorator;
use Fast\Vendor\Repositories\Eloquent\VendorActivityLogRepository;
use Fast\Vendor\Repositories\Eloquent\VendorRepository;
use Fast\Vendor\Repositories\Interfaces\VendorActivityLogInterface;
use Fast\Vendor\Repositories\Interfaces\VendorInterface;
use Event;
use Illuminate\Support\ServiceProvider;

class VendorServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register()
    {
        config([
            'auth.guards.vendor'     => [
                'driver'   => 'session',
                'provider' => 'vendors',
            ],
            'auth.providers.vendors' => [
                'driver' => 'eloquent',
                'model'  => Vendor::class,
            ],
            'auth.passwords.vendors' => [
                'provider' => 'vendors',
                'table'    => 'vendor_password_resets',
                'expire'   => 60,
            ],
            'auth.guards.vendor-api' => [
                'driver'   => 'passport',
                'provider' => 'vendors',
            ],
        ]);

        $router = $this->app->make('router');

        $router->aliasMiddleware('vendor', RedirectIfNotVendor::class);
        $router->aliasMiddleware('vendor.guest', RedirectIfVendor::class);
        $router->aliasMiddleware('vendor.media', VendorMediaMiddleware::class);

        $this->app->bind(VendorInterface::class, function () {
            return new VendorCacheDecorator(new VendorRepository(new Vendor));
        });

        $this->app->bind(VendorActivityLogInterface::class, function () {
            return new VendorActivityLogCacheDecorator(new VendorActivityLogRepository(new VendorActivityLog));
        });

        $this->app->bind(PackageInterface::class, function () {
            return new PackageCacheDecorator(
                new PackageRepository(new Package)
            );
        });


        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/vendor')
            ->loadAndPublishConfigurations(['general', 'permissions', 'assets'])
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes(['web', 'api'])
            ->loadMigrations()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-plugins-vendor',
                    'priority'    => 22,
                    'parent_id'   => null,
                    'name'        => 'plugins/vendor::vendor.name',
                    'icon'        => 'fa fa-users',
                    'url'         => route('vendor.index'),
                    'permissions' => ['vendor.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-package',
                    'priority'    => 23,
                    'parent_id'   => null,
                    'name'        => 'plugins/vendor::package.name',
                    'icon'        => 'fas fa-money-check-alt',
                    'url'         => route('package.index'),
                    'permissions' => ['package.index'],
                ]);

        });

        $this->app->register(EventServiceProvider::class);

        add_filter(IS_IN_ADMIN_FILTER, [$this, 'setInAdmin'], 20, 0);
    }

    /**
     * @return bool
     */
    public function setInAdmin(): bool
    {
        return in_array(request()->segment(1), ['account', config('core.base.general.admin_dir')]);
    }
}
