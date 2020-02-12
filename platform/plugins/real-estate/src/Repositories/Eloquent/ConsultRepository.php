<?php

namespace Fast\RealEstate\Repositories\Eloquent;

use Fast\RealEstate\Enums\ConsultStatusEnum;
use Fast\Support\Repositories\Eloquent\RepositoriesAbstract;
use Fast\RealEstate\Repositories\Interfaces\ConsultInterface;

class ConsultRepository extends RepositoriesAbstract implements ConsultInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUnread($select = ['*'])
    {
        $data = $this->model->where('status', ConsultStatusEnum::UNREAD)->select($select)->get();
        $this->resetModel();

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function countUnread()
    {
        $data = $this->model->where('status', ConsultStatusEnum::UNREAD)->count();
        $this->resetModel();

        return $data;
    }
}
