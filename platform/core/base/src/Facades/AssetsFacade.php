<?php

namespace Fast\Base\Facades;

use Fast\Base\Supports\Assets\Assets;
use Illuminate\Support\Facades\Facade;

class AssetsFacade extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Assets::class;
    }
}
