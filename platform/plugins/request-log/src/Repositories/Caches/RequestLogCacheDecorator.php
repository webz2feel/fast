<?php

namespace Fast\RequestLog\Repositories\Caches;

use Fast\Support\Repositories\Caches\CacheAbstractDecorator;
use Fast\Support\Services\Cache\CacheInterface;
use Fast\RequestLog\Repositories\Interfaces\RequestLogInterface;

class RequestLogCacheDecorator extends CacheAbstractDecorator implements RequestLogInterface
{

    /**
     * @var RequestLogInterface
     */
    protected $repository;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * PostCacheDecorator constructor.
     * @param RequestLogInterface $repository
     * @param CacheInterface $cache
     * @author Imran Ali
     */
    public function __construct(RequestLogInterface $repository, CacheInterface $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }
}
