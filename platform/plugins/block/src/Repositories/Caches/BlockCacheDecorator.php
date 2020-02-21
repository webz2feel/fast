<?php

namespace Fast\Block\Repositories\Caches;

use Fast\Support\Repositories\Caches\CacheAbstractDecorator;
use Fast\Support\Services\Cache\CacheInterface;
use Fast\Block\Repositories\Interfaces\BlockInterface;

class BlockCacheDecorator extends CacheAbstractDecorator implements BlockInterface
{
    /**
     * @var BlockInterface
     */
    protected $repository;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * BlockCacheDecorator constructor.
     * @param BlockInterface $repository
     * @param CacheInterface $cache
     * @author Imran Ali
     */
    public function __construct(BlockInterface $repository, CacheInterface $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }

    /**
     * @param string $name
     * @param int $id
     * @return mixed
     * @author Imran Ali
     */
    public function createSlug($name, $id)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
