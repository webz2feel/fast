<?php

namespace Fast\Language\Facades;

use Fast\Language\LanguageManager;
use Illuminate\Support\Facades\Facade;

class LanguageFacade extends Facade
{

    /**
     * @return string
     *
     */
    protected static function getFacadeAccessor()
    {
        return LanguageManager::class;
    }
}
