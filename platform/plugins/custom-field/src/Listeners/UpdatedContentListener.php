<?php

namespace Fast\CustomField\Listeners;

use Fast\Base\Events\UpdatedContentEvent;
use CustomField;
use Exception;

class UpdatedContentListener
{

    /**
     * Handle the event.
     *
     * @param UpdatedContentEvent $event
     * @return void
     * @author Imran Ali
     */
    public function handle(UpdatedContentEvent $event)
    {
        try {
            CustomField::saveCustomFields($event->screen, $event->request, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
