<?php

namespace Fast\Member\Repositories\Caches;

use Fast\Member\Repositories\Interfaces\MemberInterface;
use Fast\Support\Repositories\Caches\CacheAbstractDecorator;
use Fast\Support\Services\Cache\CacheInterface;

class MemberCacheDecorator extends CacheAbstractDecorator implements MemberInterface
{
    /**
     * @var MemberInterface
     */
    protected $repository;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * MemberCacheDecorator constructor.
     * @param MemberInterface $repository
     * @param CacheInterface $cache
     * @author Imran Ali
     */
    public function __construct(MemberInterface $repository, CacheInterface $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }
}
