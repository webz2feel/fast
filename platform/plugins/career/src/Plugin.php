<?php

namespace Fast\Career;

use Schema;
use Fast\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('careers');
    }
}
