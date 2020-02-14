<?php

namespace Fast\Software\Repositories\Eloquent;

use Fast\Base\Enums\BaseStatusEnum;
use Fast\Software\Repositories\Interfaces\CompatibilityInterface;
use Fast\Support\Repositories\Eloquent\RepositoriesAbstract;

class SystemRepository extends RepositoriesAbstract implements CompatibilityInterface
{

    /**
     * {@inheritdoc}
     */
    public function getDataSiteMap()
    {
        $data = $this->model
            ->with('slugable')
            ->where('system.status', '=', BaseStatusEnum::PUBLISHED)
            ->select('system.*')
            ->orderBy('system.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getPopularSystems($limit)
    {
        $data = $this->model
            ->with('slugable')
            ->orderBy('system.id', 'DESC')
            ->select('system.*')
            ->limit($limit);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllSystems($active = true)
    {
        $data = $this->model->select('system.*');
        if ($active) {
            $data = $data->where(['system.status' => BaseStatusEnum::PUBLISHED]);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
