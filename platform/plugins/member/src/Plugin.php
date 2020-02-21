<?php

namespace Fast\Member;

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
        Schema::dropIfExists('members');
        Schema::dropIfExists('member_password_resets');
    }
}
