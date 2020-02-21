<?php

namespace Fast\Note\Listeners;

use Fast\Base\Events\DeletedContentEvent;
use Exception;
use Note;

class DeletedContentListener
{

    /**
     * Handle the event.
     *
     * @param DeletedContentEvent $event
     * @return void
     * @author Imran Ali
     */
    public function handle(DeletedContentEvent $event)
    {
        try {
            Note::deleteNote($event->screen, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
