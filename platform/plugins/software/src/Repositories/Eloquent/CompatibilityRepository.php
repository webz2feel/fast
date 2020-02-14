<?php

namespace Fast\Software\Repositories\Eloquent;

use Fast\Base\Enums\BaseStatusEnum;
use Fast\Software\Repositories\Interfaces\CompatibilityInterface;
use Fast\Support\Repositories\Eloquent\RepositoriesAbstract;

class CompatibilityRepository extends RepositoriesAbstract implements CompatibilityInterface
{

    /**
     * {@inheritdoc}
     */
    public function getDataSiteMap()
    {
        $data = $this->model
            ->with('slugable')
            ->where('software_compatibilities.status', '=', BaseStatusEnum::PUBLISHED)
            ->select('software_compatibilities.*')
            ->orderBy('software_compatibilities.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getPopularCompatibilities($limit)
    {
        $data = $this->model
            ->with('slugable')
            ->orderBy('software_compatibilities.id', 'DESC')
            ->select('software_compatibilities.*')
            ->limit($limit);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllCompatibilities($active = true)
    {
        $data = $this->model->select('software_compatibilities.*');
        if ($active) {
            $data = $data->where(['software_compatibilities.status' => BaseStatusEnum::PUBLISHED]);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
