<?php

namespace Fast\Language\Listeners;

use Fast\Base\Events\UpdatedContentEvent;
use Exception;
use Language;

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
            Language::saveLanguage($event->screen, $event->request, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
