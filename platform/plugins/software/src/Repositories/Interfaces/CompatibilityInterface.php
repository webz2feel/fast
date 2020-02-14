<?php

namespace Fast\Software\Repositories\Interfaces;

use Fast\Support\Repositories\Interfaces\RepositoryInterface;

interface CompatibilityInterface extends RepositoryInterface
{

    /**
     * @return mixed
     */
    public function getDataSiteMap();

    /**
     * @param int $limit
     * @return mixed
     */
    public function getPopularCompatibilities($limit);

    /**
     * @param bool $active
     * @return mixed
     */
    public function getAllCompatibilities($active = true);
}
