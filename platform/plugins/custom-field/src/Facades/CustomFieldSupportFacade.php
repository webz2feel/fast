<?php

namespace Fast\CustomField\Facades;

use Illuminate\Support\Facades\Facade;
use Fast\CustomField\Support\CustomFieldSupport;

/**
 * Class CustomFieldSupportFacade
 * @package Fast\CustomField\Facades
 */
class CustomFieldSupportFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CustomFieldSupport::class;
    }
}
