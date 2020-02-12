<?php

namespace Fast\Contact\Repositories\Caches;

use Fast\Support\Repositories\Caches\CacheAbstractDecorator;
use Fast\Contact\Repositories\Interfaces\ContactInterface;

class ContactCacheDecorator extends CacheAbstractDecorator implements ContactInterface
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
