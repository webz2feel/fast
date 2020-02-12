<?php

namespace Fast\Base\Facades;

use Fast\Base\Supports\PageTitle;
use Illuminate\Support\Facades\Facade;

class PageTitleFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PageTitle::class;
    }
}
