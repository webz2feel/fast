<?php

namespace Fast\Base\Providers;

use Fast\Base\Events\BeforeEditContentEvent;
use Fast\Base\Events\CreatedContentEvent;
use Fast\Base\Events\DeletedContentEvent;
use Fast\Base\Events\SendMailEvent;
use Fast\Base\Events\UpdatedContentEvent;
use Fast\Base\Listeners\BeforeEditContentListener;
use Fast\Base\Listeners\CreatedContentListener;
use Fast\Base\Listeners\DeletedContentListener;
use Fast\Base\Listeners\SendMailListener;
use Fast\Base\Listeners\UpdatedContentListener;
use Event;
use File;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        SendMailEvent::class          => [
            SendMailListener::class,
        ],
        CreatedContentEvent::class    => [
            CreatedContentListener::class,
        ],
        UpdatedContentEvent::class    => [
            UpdatedContentListener::class,
        ],
        DeletedContentEvent::class    => [
            DeletedContentListener::class,
        ],
        BeforeEditContentEvent::class => [
            BeforeEditContentListener::class,
        ],
    ];

    public function boot()
    {
        parent::boot();

        Event::listen(['cache:cleared'], function () {
            File::delete([storage_path('cache_keys.json'), storage_path('settings.json')]);
        });
    }
}
