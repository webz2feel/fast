<?php

namespace Fast\LogViewer\Facades;

use Illuminate\Support\Facades\Facade;

class LogViewerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     * @author Imran Ali
     */
    protected static function getFacadeAccessor()
    {
        return 'botble::log-viewer';
    }
}
