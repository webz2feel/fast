<?php

namespace Fast\RequestLog;

use Fast\Base\Interfaces\PluginInterface;
use Fast\Dashboard\Repositories\Interfaces\DashboardWidgetInterface;
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
        Schema::dropIfExists('request_logs');
        app(DashboardWidgetInterface::class)->deleteBy(['name' => 'widget_request_errors']);
    }
}
