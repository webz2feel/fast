<?php

namespace Fast\Base\Facades;

use Fast\Base\Supports\MailVariable;
use Illuminate\Support\Facades\Facade;

class MailVariableFacade extends Facade
{

    /**
     * @return string
     *
     * @since 3.2
     */
    protected static function getFacadeAccessor()
    {
        return MailVariable::class;
    }
}
