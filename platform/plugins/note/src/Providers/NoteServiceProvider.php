<?php

namespace Fast\Note\Providers;

use Fast\Base\Traits\LoadAndPublishDataTrait;
use Fast\Note\Facades\NoteFacade;
use Fast\Support\Services\Cache\Cache;
use Fast\Base\Supports\Helper;
use Fast\Note\Models\Note;
use Fast\Note\Repositories\Caches\NoteCacheDecorator;
use Fast\Note\Repositories\Eloquent\NoteRepository;
use Fast\Note\Repositories\Interfaces\NoteInterface;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

/**
 * Class NoteServiceProvider
 * @package Fast\Note
 * @author Imran Ali
 * @since 07/02/2016 09:50 AM
 */
class NoteServiceProvider extends ServiceProvider
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
            $this->app->singleton(NoteInterface::class, function () {
                return new NoteCacheDecorator(new NoteRepository(new Note()), new Cache($this->app['cache'], NoteRepository::class));
            });
        } else {
            $this->app->singleton(NoteInterface::class, function () {
                return new NoteRepository(new Note());
            });
        }

        Helper::autoload(__DIR__ . '/../../helpers');

        AliasLoader::getInstance()->alias('Note', NoteFacade::class);
    }

    /**
     * Boot the service provider.
     * @author Imran Ali
     */
    public function boot()
    {
        $this->setIsInConsole($this->app->runningInConsole())
            ->setNamespace('plugins/note')
            ->loadAndPublishViews()
            ->loadAndPublishConfigurations(['general'])
            ->loadMigrations();

        $this->app->register(HookServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
    }
}
