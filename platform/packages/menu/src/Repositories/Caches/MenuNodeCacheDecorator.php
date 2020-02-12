<?php

namespace Fast\Menu\Repositories\Caches;

use Fast\Menu\Repositories\Interfaces\MenuNodeInterface;
use Fast\Support\Repositories\Caches\CacheAbstractDecorator;

class MenuNodeCacheDecorator extends CacheAbstractDecorator implements MenuNodeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getByMenuId($menuId, $parentId, $select = ['*'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
