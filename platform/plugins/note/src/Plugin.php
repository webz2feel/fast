<?php

namespace Fast\Note;

use Fast\Base\Interfaces\PluginInterface;
use Schema;

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
        Schema::dropIfExists('notes');
    }
}
