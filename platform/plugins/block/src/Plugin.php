<?php

namespace Fast\Block;

use Schema;
use Fast\Base\Interfaces\PluginInterface;

class Plugin implements PluginInterface
{

    /**
     * @author Imran Ali
     */
    public static function activate()
    {
    }

    /**
     * @author Imran Ali
     */
    public static function deactivate()
    {
    }

    /**
     * @author Imran Ali
     */
    public static function remove()
    {
        Schema::dropIfExists('block');
    }
}
