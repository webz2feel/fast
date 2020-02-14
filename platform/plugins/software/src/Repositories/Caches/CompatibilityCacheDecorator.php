<?php

namespace Fast\Software\Repositories\Caches;

use Fast\Software\Repositories\Interfaces\CompatibilityInterface;
use Fast\Support\Repositories\Caches\CacheAbstractDecorator;

class CompatibilityCacheDecorator extends CacheAbstractDecorator implements CompatibilityInterface
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
    public function getPopularCompatibilities($limit)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getAllCompatibilities($active = true)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
