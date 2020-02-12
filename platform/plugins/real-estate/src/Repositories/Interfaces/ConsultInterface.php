<?php

namespace Fast\RealEstate\Repositories\Interfaces;

use Fast\Support\Repositories\Interfaces\RepositoryInterface;

interface ConsultInterface extends RepositoryInterface
{
    /**
     * @param array $select
     * @return mixed
     */
    public function getUnread($select = ['*']);

    /**
     * @return int
     */
    public function countUnread();
}
