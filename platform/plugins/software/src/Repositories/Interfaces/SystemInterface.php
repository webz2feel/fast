<?php

namespace Fast\Software\Repositories\Interfaces;

use Fast\Support\Repositories\Interfaces\RepositoryInterface;

interface SystemInterface extends RepositoryInterface
{

    /**
     * @return mixed
     */
    public function getDataSiteMap();

    /**
     * @param int $limit
     * @return mixed
     */
    public function getPopularSystems($limit);

    /**
     * @param bool $active
     * @return mixed
     */
    public function getAllSystems($active = true);
}
