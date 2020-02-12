<?php

namespace Fast\RealEstate\Repositories\Caches;

use Fast\RealEstate\Repositories\Interfaces\ProjectInterface;
use Fast\Support\Repositories\Caches\CacheAbstractDecorator;

class ProjectCacheDecorator extends CacheAbstractDecorator implements ProjectInterface
{
    /**
     * {@inheritdoc}
     */
    public function getProjects($filters = [], $params = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getRelatedProjects(int $projectId, $limit = 4)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
