<?php

namespace Fast\Page\Repositories\Caches;

use Fast\Page\Repositories\Interfaces\PageInterface;
use Fast\Support\Repositories\Caches\CacheAbstractDecorator;

class PageCacheDecorator extends CacheAbstractDecorator implements PageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataSiteMap()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getFeaturedPages($limit)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function whereIn($array, $select = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getSearch($query, $limit = 10)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getAllPages($active = true)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
