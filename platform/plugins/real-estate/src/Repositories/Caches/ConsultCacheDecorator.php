<?php

namespace Fast\RealEstate\Repositories\Caches;

use Fast\Support\Repositories\Caches\CacheAbstractDecorator;
use Fast\RealEstate\Repositories\Interfaces\ConsultInterface;

class ConsultCacheDecorator extends CacheAbstractDecorator implements ConsultInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUnread($select = ['*'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function countUnread()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
