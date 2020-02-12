<?php

namespace Fast\Theme\Facades;

use Fast\Theme\Manager;
use Illuminate\Support\Facades\Facade;

class ManagerFacade extends Facade
{

    /**
     * @return string
     *
     * @since 2.1
     */
    protected static function getFacadeAccessor()
    {
        return Manager::class;
    }
}
