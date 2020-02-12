<?php

namespace Fast\Language;

use Fast\PluginManagement\Abstracts\PluginOperationAbstract;
use Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('languages');
        Schema::dropIfExists('language_meta');
    }
}
