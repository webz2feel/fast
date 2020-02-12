<?php

namespace Fast\Slug\Providers;

use Fast\Base\Events\CreatedContentEvent;
use Fast\Base\Events\DeletedContentEvent;
use Fast\Base\Events\UpdatedContentEvent;
use Fast\Slug\Listeners\CreatedContentListener;
use Fast\Slug\Listeners\DeletedContentListener;
use Fast\Slug\Listeners\UpdatedContentListener;
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
    ];
}
