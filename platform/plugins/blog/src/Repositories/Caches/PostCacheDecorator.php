<?php

namespace Fast\Blog\Repositories\Caches;

use Fast\Support\Repositories\Caches\CacheAbstractDecorator;
use Fast\Blog\Repositories\Interfaces\PostInterface;

class PostCacheDecorator extends CacheAbstractDecorator implements PostInterface
{
    /**
     * {@inheritdoc}
     */
    public function getFeatured($limit = 5)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getListPostNonInList(array $selected = [], $limit = 12)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getByUserId($authorId, $limit = 6)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

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
    public function getByTag($tag, $paginate = 12)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getRelated($slug, $limit = 3)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getRecentPosts($limit = 5, $categoryId = 0)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getSearch($query, $limit = 10, $paginate = 10)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getByCategory($categoryId, $paginate = 12, $limit = 0)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getAllPosts($perPage = 12, $active = true)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getPopularPosts($limit, array $args = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getRelatedCategoryIds($model)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
