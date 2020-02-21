<?php

namespace Fast\Note\Facades;

use Fast\Note\Note;
use Illuminate\Support\Facades\Facade;

class NoteFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     * @author Imran Ali
     */
    protected static function getFacadeAccessor()
    {
        return Note::class;
    }
}
