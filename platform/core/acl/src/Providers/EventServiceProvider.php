<?php

namespace Fast\ACL\Providers;

use Fast\ACL\Events\RoleAssignmentEvent;
use Fast\ACL\Events\RoleUpdateEvent;
use Fast\ACL\Listeners\LoginListener;
use Fast\ACL\Listeners\RoleAssignmentListener;
use Fast\ACL\Listeners\RoleUpdateListener;
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
        RoleUpdateEvent::class     => [
            RoleUpdateListener::class,
        ],
        RoleAssignmentEvent::class => [
            RoleAssignmentListener::class,
        ],
        Login::class               => [
            LoginListener::class,
        ],
    ];
}
