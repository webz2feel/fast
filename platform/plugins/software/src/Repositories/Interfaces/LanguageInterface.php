<?php

namespace Fast\Software\Repositories\Interfaces;

use Fast\Support\Repositories\Interfaces\RepositoryInterface;

interface LanguageInterface extends RepositoryInterface
{

    /**
     * @return mixed
     */
    public function getDataSiteMap();

    /**
     * @param int $limit
     * @return mixed
     */
    public function getPopularLanguages($limit);

    /**
     * @param bool $active
     * @return mixed
     */
    public function getAllLanguages($active = true);
}
