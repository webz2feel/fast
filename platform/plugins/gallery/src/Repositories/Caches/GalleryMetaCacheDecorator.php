<?php

namespace Fast\Gallery\Repositories\Caches;

use Fast\Support\Repositories\Caches\CacheAbstractDecorator;
use Fast\Gallery\Repositories\Interfaces\GalleryMetaInterface;
use Fast\Support\Services\Cache\CacheInterface;

class GalleryMetaCacheDecorator extends CacheAbstractDecorator implements GalleryMetaInterface
{
    /**
     * @var GalleryMetaInterface
     */
    protected $repository;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * GalleryCacheDecorator constructor.
     * @param GalleryMetaInterface $repository
     * @param CacheInterface $cache
     * @author Imran Ali
     */
    public function __construct(GalleryMetaInterface $repository, CacheInterface $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }
}
