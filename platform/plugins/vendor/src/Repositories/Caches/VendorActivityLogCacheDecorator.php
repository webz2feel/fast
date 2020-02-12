<?php

namespace Fast\Vendor\Repositories\Caches;

use Fast\Vendor\Repositories\Interfaces\VendorActivityLogInterface;
use Fast\Support\Repositories\Caches\CacheAbstractDecorator;

class VendorActivityLogCacheDecorator extends CacheAbstractDecorator implements VendorActivityLogInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAllLogs($vendorId, $paginate = 10)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
