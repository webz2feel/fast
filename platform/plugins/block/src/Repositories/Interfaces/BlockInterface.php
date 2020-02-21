<?php

namespace Fast\Block\Repositories\Interfaces;

use Fast\Support\Repositories\Interfaces\RepositoryInterface;

interface BlockInterface extends RepositoryInterface
{
    /**
     * @param string $name
     * @param int $id
     * @return mixed
     * @author Imran Ali
     */
    public function createSlug($name, $id);
}
