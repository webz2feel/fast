<?php

namespace Fast\AuditLog\Listeners;

use Fast\AuditLog\Events\AuditHandlerEvent;
use Fast\Base\Events\UpdatedContentEvent;
use Exception;
use AuditLog;

class UpdatedContentListener
{

    /**
     * Handle the event.
     *
     * @param UpdatedContentEvent $event
     * @return void
     */
    public function handle(UpdatedContentEvent $event)
    {
        try {
            if ($event->data->id) {
                event(new AuditHandlerEvent(
                    $event->screen,
                    'updated',
                    $event->data->id,
                    AuditLog::getReferenceName($event->screen, $event->data),
                    'primary'
                ));
            }
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
