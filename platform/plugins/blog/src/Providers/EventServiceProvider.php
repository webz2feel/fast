<?php

namespace Fast\Blog\Providers;

use Fast\Theme\Events\RenderingSiteMapEvent;
use Fast\Blog\Listeners\RenderingSiteMapListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RenderingSiteMapEvent::class  => [
            RenderingSiteMapListener::class,
        ],
    ];
}
