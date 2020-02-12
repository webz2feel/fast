<?php

namespace Fast\ACL\Repositories\Caches;

use Fast\ACL\Repositories\Interfaces\RoleInterface;
use Fast\Support\Repositories\Caches\CacheAbstractDecorator;

class RoleCacheDecorator extends CacheAbstractDecorator implements RoleInterface
{
    /**
     * {@inheritdoc}
     */
    public function createSlug($name, $id)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
