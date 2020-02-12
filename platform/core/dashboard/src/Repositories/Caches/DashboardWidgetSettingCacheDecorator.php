<?php

namespace Fast\Dashboard\Repositories\Caches;

use Fast\Dashboard\Repositories\Interfaces\DashboardWidgetSettingInterface;
use Fast\Support\Repositories\Caches\CacheAbstractDecorator;

class DashboardWidgetSettingCacheDecorator extends CacheAbstractDecorator implements DashboardWidgetSettingInterface
{
    /**
     * {@inheritdoc}
     */
    public function getListWidget()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
