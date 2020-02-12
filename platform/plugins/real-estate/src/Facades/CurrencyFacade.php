<?php

namespace Fast\RealEstate\Facades;

use Fast\RealEstate\Supports\CurrencySupport;
use Illuminate\Support\Facades\Facade;

class CurrencyFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CurrencySupport::class;
    }
}
