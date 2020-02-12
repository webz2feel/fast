<?php

namespace Fast\Widget\Repositories\Caches;

use Fast\Support\Repositories\Caches\CacheAbstractDecorator;
use Fast\Widget\Repositories\Interfaces\WidgetInterface;

class WidgetCacheDecorator extends CacheAbstractDecorator implements WidgetInterface
{
    /**
     * {@inheritdoc}
     */
    public function getByTheme($theme)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
