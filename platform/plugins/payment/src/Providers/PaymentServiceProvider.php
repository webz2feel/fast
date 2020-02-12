<?php

namespace Fast\Payment\Providers;

use Fast\Base\Supports\Helper;
use Fast\Base\Traits\LoadAndPublishDataTrait;
use Fast\Payment\Models\Payment;
use Event;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;
use Fast\Payment\Repositories\Caches\PaymentCacheDecorator;
use Fast\Payment\Repositories\Eloquent\PaymentRepository;
use Fast\Payment\Repositories\Interfaces\PaymentInterface;

class PaymentServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->singleton(PaymentInterface::class, function () {
            return new PaymentCacheDecorator(new PaymentRepository(new Payment));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/payment')
            ->loadAndPublishConfigurations(['payment'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web'])
            ->loadMigrations()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-payments',
                'priority'    => 800,
                'parent_id'   => 'cms-plugins-job-board',
                'name'        => 'plugins/payment::payment.payment_methods',
                'icon'        => null,
                'url'         => route('payments.methods'),
                'permissions' => ['payments.methods'],
            ]);
        });

    }
}
