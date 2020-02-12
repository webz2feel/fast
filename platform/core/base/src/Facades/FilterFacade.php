<?php

namespace Fast\Base\Facades;

use Fast\Base\Supports\Filter;
use Illuminate\Support\Facades\Facade;

class FilterFacade extends Facade
{

    /**
     * @return string
     *
     * @since 2.1
     */
    protected static function getFacadeAccessor()
    {
        return Filter::class;
    }
}
