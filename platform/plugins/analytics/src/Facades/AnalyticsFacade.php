<?php

namespace Fast\Analytics\Facades;

use Fast\Analytics\Analytics;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Fast\Analytics\Analytics
 */
class AnalyticsFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Analytics::class;
    }
}
