<?php

namespace Fast\Vendor\Repositories\Eloquent;

use Fast\Vendor\Repositories\Interfaces\VendorActivityLogInterface;
use Fast\Support\Repositories\Eloquent\RepositoriesAbstract;

class VendorActivityLogRepository extends RepositoriesAbstract implements VendorActivityLogInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAllLogs($vendorId, $paginate = 10)
    {
        return $this->model
            ->where('vendor_id', $vendorId)
            ->latest('created_at')
            ->paginate($paginate);
    }
}
