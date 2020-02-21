<?php

namespace Fast\Note\Repositories\Caches;

use Fast\Support\Repositories\Caches\CacheAbstractDecorator;
use Fast\Support\Services\Cache\CacheInterface;
use Fast\Note\Repositories\Interfaces\NoteInterface;

class NoteCacheDecorator extends CacheAbstractDecorator implements NoteInterface
{
    /**
     * @var NoteInterface
     */
    protected $repository;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * NoteCacheDecorator constructor.
     * @param NoteInterface $repository
     * @param CacheInterface $cache
     * @author Imran Ali
     */
    public function __construct(NoteInterface $repository, CacheInterface $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }
}
