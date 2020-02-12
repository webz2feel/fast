<?php

namespace Fast\Widget\Providers;

use Fast\Base\Supports\Helper;
use Fast\Base\Traits\LoadAndPublishDataTrait;
use Fast\Widget\Factories\WidgetFactory;
use Fast\Widget\Misc\LaravelApplicationWrapper;
use Fast\Widget\Models\Widget;
use Fast\Widget\Repositories\Caches\WidgetCacheDecorator;
use Fast\Widget\Repositories\Eloquent\WidgetRepository;
use Fast\Widget\Repositories\Interfaces\WidgetInterface;
use Fast\Widget\WidgetGroupCollection;
use Fast\Widget\Widgets\Text;
use Event;
use File;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;
use WidgetGroup;

class WidgetServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * @var Application
     */
    protected $app;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(WidgetInterface::class, function () {
            return new WidgetCacheDecorator(new WidgetRepository(new Widget));
        });

        $this->app->bind('fast.widget', function () {
            return new WidgetFactory(new LaravelApplicationWrapper);
        });

        $this->app->singleton('fast.widget-group-collection', function () {
            return new WidgetGroupCollection(new LaravelApplicationWrapper);
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->setNamespace('packages/widget')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadRoutes(['web'])
            ->loadMigrations()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets();

        $this->app->booted(function () {

            WidgetGroup::setGroup([
                'id'          => 'primary_sidebar',
                'name'        => 'Primary sidebar',
                'description' => 'This is primary sidebar section',
            ]);

            register_widget(Text::class);

            $widget_path = theme_path(setting('theme') . '/widgets');
            $widgets = scan_folder($widget_path);
            if (!empty($widgets) && is_array($widgets)) {
                foreach ($widgets as $widget) {
                    $registration = $widget_path . '/' . $widget . '/registration.php';
                    if (File::exists($registration)) {
                        File::requireOnce($registration);
                    }
                }
            }
        });

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-core-widget',
                    'priority'    => 3,
                    'parent_id'   => 'cms-core-appearance',
                    'name'        => 'core/base::layouts.widgets',
                    'icon'        => null,
                    'url'         => route('widgets.index'),
                    'permissions' => ['widgets.index'],
                ]);

            if (function_exists('admin_bar')) {
                admin_bar()->registerLink('Widget', route('widgets.index'), 'appearance');
            }
        });
    }
}
