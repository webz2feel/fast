<?php

namespace Fast\Software\Repositories\Caches;

use Fast\Software\Repositories\Interfaces\SystemInterface;
use Fast\Support\Repositories\Caches\CacheAbstractDecorator;

class SystemCacheDecorator extends CacheAbstractDecorator implements SystemInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataSiteMap()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getPopularSystems($limit)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getAllSystems($active = true)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
