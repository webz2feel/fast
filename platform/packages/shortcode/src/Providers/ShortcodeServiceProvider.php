<?php

namespace Fast\Shortcode\Providers;

use Fast\Base\Supports\Helper;
use Fast\Shortcode\Compilers\ShortcodeCompiler;
use Fast\Shortcode\Shortcode;
use Fast\Shortcode\View\Factory;
use Illuminate\Support\ServiceProvider;

class ShortcodeServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     * @since 2.1
     */
    public function register()
    {
        $this->app->singleton('shortcode.compiler', ShortcodeCompiler::class);

        $this->app->singleton('shortcode', function ($app) {
            return new Shortcode($app['shortcode.compiler']);
        });

        $this->app->singleton('view', function ($app) {
            // Next we need to grab the engine resolver instance that will be used by the
            // environment. The resolver will be used by an environment to get each of
            // the various engine implementations such as plain PHP or Blade engine.
            $resolver = $app['view.engine.resolver'];
            $finder = $app['view.finder'];
            $env = new Factory($resolver, $finder, $app['events'], $app['shortcode.compiler']);
            // We will also set the container instance on this view environment since the
            // view composers may be classes registered in the container, which allows
            // for great testable, flexible composers for the application developer.
            $env->setContainer($app);
            $env->share('app', $app);
            return $env;
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }
}
