<?php

namespace Fast\Contact\Repositories\Eloquent;

use Fast\Contact\Enums\ContactStatusEnum;
use Fast\Contact\Repositories\Interfaces\ContactInterface;
use Fast\Support\Repositories\Eloquent\RepositoriesAbstract;

class ContactRepository extends RepositoriesAbstract implements ContactInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUnread($select = ['*'])
    {
        $data = $this->model->where('status', ContactStatusEnum::UNREAD)->select($select)->get();
        $this->resetModel();
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function countUnread()
    {
        $data = $this->model->where('status', ContactStatusEnum::UNREAD)->count();
        $this->resetModel();
        return $data;
    }
}
