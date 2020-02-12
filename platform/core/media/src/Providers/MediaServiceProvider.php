<?php

namespace Fast\Media\Providers;

use Fast\Base\Supports\Helper;
use Fast\Base\Traits\LoadAndPublishDataTrait;
use Fast\Media\Commands\DeleteThumbnailCommand;
use Fast\Media\Commands\GenerateThumbnailCommand;
use Fast\Media\Facades\RvMediaFacade;
use Fast\Media\Models\MediaFile;
use Fast\Media\Models\MediaFolder;
use Fast\Media\Models\MediaSetting;
use Fast\Media\Repositories\Caches\MediaFileCacheDecorator;
use Fast\Media\Repositories\Caches\MediaFolderCacheDecorator;
use Fast\Media\Repositories\Caches\MediaSettingCacheDecorator;
use Fast\Media\Repositories\Eloquent\MediaFileRepository;
use Fast\Media\Repositories\Eloquent\MediaFolderRepository;
use Fast\Media\Repositories\Eloquent\MediaSettingRepository;
use Fast\Media\Repositories\Interfaces\MediaFileInterface;
use Fast\Media\Repositories\Interfaces\MediaFolderInterface;
use Fast\Media\Repositories\Interfaces\MediaSettingInterface;
use Event;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;

/**
 * @since 02/07/2016 09:50 AM
 */
class MediaServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        Helper::autoload(__DIR__ . '/../../helpers');

        $this->app->bind(MediaFileInterface::class, function () {
            return new MediaFileCacheDecorator(
                new MediaFileRepository(new MediaFile),
                MEDIA_GROUP_CACHE_KEY
            );
        });

        $this->app->bind(MediaFolderInterface::class, function () {
            return new MediaFolderCacheDecorator(
                new MediaFolderRepository(new MediaFolder),
                MEDIA_GROUP_CACHE_KEY
            );
        });

        $this->app->bind(MediaSettingInterface::class, function () {
            return new MediaSettingCacheDecorator(
                new MediaSettingRepository(new MediaSetting)
            );
        });

        AliasLoader::getInstance()->alias('RvMedia', RvMediaFacade::class);
    }

    public function boot()
    {
        $this->setNamespace('core/media')
            ->loadAndPublishConfigurations(['permissions', 'media'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-core-media',
                'priority'    => 995,
                'parent_id'   => null,
                'name'        => 'core/media::media.menu_name',
                'icon'        => 'far fa-images',
                'url'         => route('media.index'),
                'permissions' => ['media.index'],
            ]);
        });

        $this->commands([
            GenerateThumbnailCommand::class,
            DeleteThumbnailCommand::class,
        ]);
    }
}
