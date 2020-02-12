<?php

namespace Fast\Theme\Facades;

use Fast\Theme\Supports\SiteMapManager;
use Illuminate\Support\Facades\Facade;

class SiteMapManagerFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SiteMapManager::class;
    }
}
