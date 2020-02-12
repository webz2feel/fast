<?php

namespace Fast\Language\Providers;

use Fast\Base\Events\CreatedContentEvent;
use Fast\Base\Events\DeletedContentEvent;
use Fast\Base\Events\UpdatedContentEvent;
use Fast\Language\Listeners\CreatedContentListener;
use Fast\Language\Listeners\DeletedContentListener;
use Fast\Language\Listeners\ThemeRemoveListener;
use Fast\Language\Listeners\UpdatedContentListener;
use Fast\Theme\Events\ThemeRemoveEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UpdatedContentEvent::class => [
            UpdatedContentListener::class,
        ],
        CreatedContentEvent::class => [
            CreatedContentListener::class,
        ],
        DeletedContentEvent::class => [
            DeletedContentListener::class,
        ],
        ThemeRemoveEvent::class    => [
            ThemeRemoveListener::class,
        ],
    ];
}
