<?php

namespace Fast\SocialLogin\Facades;

use Fast\SocialLogin\Supports\SocialService;
use Illuminate\Support\Facades\Facade;

class SocialServiceFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SocialService::class;
    }
}
