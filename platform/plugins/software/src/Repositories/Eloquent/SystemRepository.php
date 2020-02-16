<?php

namespace Fast\Software\Repositories\Eloquent;

use Fast\Base\Enums\BaseStatusEnum;
use Fast\Software\Repositories\Interfaces\SystemInterface;
use Fast\Support\Repositories\Eloquent\RepositoriesAbstract;

class SystemRepository extends RepositoriesAbstract implements SystemInterface
{

    /**
     * {@inheritdoc}
     */
    public function getDataSiteMap()
    {
        $data = $this->model
            ->with('slugable')
            ->where('software_systems.status', '=', BaseStatusEnum::PUBLISHED)
            ->select('software_systems.*')
            ->orderBy('software_systems.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getPopularSystems($limit)
    {
        $data = $this->model
            ->with('slugable')
            ->orderBy('software_systems.id', 'DESC')
            ->select('software_systems.*')
            ->limit($limit);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllSystems($active = true)
    {
        $data = $this->model->select('software_systems.*');
        if ($active) {
            $data = $data->where(['software_systems.status' => BaseStatusEnum::PUBLISHED]);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
