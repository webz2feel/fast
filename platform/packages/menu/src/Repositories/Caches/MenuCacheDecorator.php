<?php

namespace Fast\Menu\Repositories\Caches;

use Fast\Menu\Repositories\Interfaces\MenuInterface;
use Fast\Support\Repositories\Caches\CacheAbstractDecorator;

class MenuCacheDecorator extends CacheAbstractDecorator implements MenuInterface
{

    /**
     * {@inheritdoc}
     */
    public function findBySlug($slug, $active, $selects = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function createSlug($name)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
