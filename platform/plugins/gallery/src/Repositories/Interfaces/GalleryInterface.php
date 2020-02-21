<?php

namespace Fast\Gallery\Repositories\Interfaces;

use Fast\Support\Repositories\Interfaces\RepositoryInterface;

interface GalleryInterface extends RepositoryInterface
{

    /**
     * Get all galleries.
     *
     * @return mixed
     * @author Imran Ali
     */
    public function getAll();

    /**
     * @return mixed
     * @author Imran Ali
     */
    public function getDataSiteMap();

    /**
     * @param $limit
     * @author Imran Ali
     */
    public function getFeaturedGalleries($limit);
}
