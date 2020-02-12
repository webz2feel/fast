<?php

namespace Fast\AuditLog\Providers;

use Fast\AuditLog\Events\AuditHandlerEvent;
use Fast\AuditLog\Listeners\AuditHandlerListener;
use Fast\AuditLog\Listeners\CreatedContentListener;
use Fast\AuditLog\Listeners\DeletedContentListener;
use Fast\AuditLog\Listeners\LoginListener;
use Fast\AuditLog\Listeners\UpdatedContentListener;
use Fast\Base\Events\CreatedContentEvent;
use Fast\Base\Events\DeletedContentEvent;
use Fast\Base\Events\UpdatedContentEvent;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AuditHandlerEvent::class   => [
            AuditHandlerListener::class,
        ],
        Login::class               => [
            LoginListener::class,
        ],
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
