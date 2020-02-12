<?php

namespace Fast\Vendor\Repositories\Interfaces;

use Fast\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface VendorActivityLogInterface extends RepositoryInterface
{
    /**
     * @param $vendorId
     * @param int $paginate
     * @return Collection
     */
    public function getAllLogs($vendorId, $paginate = 10);
}
