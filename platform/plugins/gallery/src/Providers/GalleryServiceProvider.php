<?php

namespace Fast\Gallery\Providers;

use Fast\Base\Events\SessionStarted;
use Fast\Base\Supports\Helper;
use Fast\Base\Traits\LoadAndPublishDataTrait;
use Fast\Gallery\Facades\GalleryFacade;
use Fast\Gallery\Models\Gallery;
use Fast\Gallery\Models\GalleryMeta;
use Fast\Gallery\Repositories\Caches\GalleryMetaCacheDecorator;
use Fast\Gallery\Repositories\Eloquent\GalleryMetaRepository;
use Fast\Gallery\Repositories\Interfaces\GalleryMetaInterface;
use Event;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Fast\Gallery\Repositories\Caches\GalleryCacheDecorator;
use Fast\Gallery\Repositories\Eloquent\GalleryRepository;
use Fast\Gallery\Repositories\Interfaces\GalleryInterface;
use Fast\Support\Services\Cache\Cache;
use Language;
use SeoHelper;

class GalleryServiceProvider extends ServiceProvider
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
            $this->app->singleton(GalleryInterface::class, function () {
                return new GalleryCacheDecorator(new GalleryRepository(new Gallery()), new Cache($this->app['cache'], GalleryRepository::class));
            });

            $this->app->singleton(GalleryMetaInterface::class, function () {
                return new GalleryMetaCacheDecorator(new GalleryMetaRepository(new GalleryMeta()), new Cache($this->app['cache'], GalleryMetaRepository::class));
            });
        } else {
            $this->app->singleton(GalleryInterface::class, function () {
                return new GalleryRepository(new Gallery());
            });

            $this->app->singleton(GalleryMetaInterface::class, function () {
                return new GalleryMetaRepository(new GalleryMeta());
            });
        }

        Helper::autoload(__DIR__ . '/../../helpers');

        AliasLoader::getInstance()->alias('Gallery', GalleryFacade::class);
    }

    /**
     * @author Imran Ali
     */
    public function boot()
    {
        $this->setIsInConsole($this->app->runningInConsole())
            ->setNamespace('plugins/gallery')
            ->loadAndPublishConfigurations(['general', 'permissions'])
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssetsFolder()
            ->publishPublicFolder();

        $this->app->register(HookServiceProvider::class);
        $this->app->register(EventServiceProvider::class);

        Event::listen(SessionStarted::class, function () {
            dashboard_menu()->registerItem([
                'id' => 'cms-plugins-gallery', // key of menu, it should unique
                'priority' => 5,
                'parent_id' => null,
                'name' => trans('plugins.gallery::gallery.menu_name'), // menu name, if you don't need translation, you can use the name in plain text
                'icon' => 'fa fa-camera',
                'url' => route('galleries.list'),
                'permissions' => ['galleries.list'], // permission should same with route name, you can see that flag in Plugin.php
            ]);
        });

        if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
            Language::registerModule([GALLERY_MODULE_SCREEN_NAME]);
        }

        $this->app->booted(function () {
            config(['core.slug.general.supported' => array_merge(config('core.slug.general.supported'), [GALLERY_MODULE_SCREEN_NAME])]);

            config(['core.slug.general.prefixes.' . GALLERY_MODULE_SCREEN_NAME => 'gallery']);

            SeoHelper::registerModule([GALLERY_MODULE_SCREEN_NAME]);
        });
    }
}
