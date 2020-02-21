<?php

namespace Fast\CustomField\Repositories\Caches;

use Fast\CustomField\Repositories\Interfaces\CustomFieldInterface;
use Fast\Support\Repositories\Caches\CacheAbstractDecorator;
use Fast\Support\Services\Cache\CacheInterface;

class CustomFieldCacheDecorator extends CacheAbstractDecorator implements CustomFieldInterface
{
    /**
     * @var CustomFieldInterface
     */
    protected $repository;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * CustomFieldCacheDecorator constructor.
     * @param CustomFieldInterface $repository
     * @param CacheInterface $cache
     * @author Imran Ali
     */
    public function __construct(CustomFieldInterface $repository, CacheInterface $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }
}
