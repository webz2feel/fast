<?php

namespace Fast\Gallery\Facades;

use Fast\Gallery\Gallery;
use Illuminate\Support\Facades\Facade;

class GalleryFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     * @author Imran Ali
     */
    protected static function getFacadeAccessor()
    {
        return Gallery::class;
    }
}
