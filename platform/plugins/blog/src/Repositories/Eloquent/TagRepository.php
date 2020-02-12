<?php

namespace Fast\Blog\Repositories\Eloquent;

use Fast\Base\Enums\BaseStatusEnum;
use Fast\Support\Repositories\Eloquent\RepositoriesAbstract;
use Fast\Blog\Repositories\Interfaces\TagInterface;

class TagRepository extends RepositoriesAbstract implements TagInterface
{

    /**
     * {@inheritdoc}
     */
    public function getDataSiteMap()
    {
        $data = $this->model
            ->with('slugable')
            ->where('tags.status', '=', BaseStatusEnum::PUBLISHED)
            ->select('tags.*')
            ->orderBy('tags.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getPopularTags($limit)
    {
        $data = $this->model
            ->with('slugable')
            ->orderBy('tags.id', 'DESC')
            ->select('tags.*')
            ->limit($limit);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllTags($active = true)
    {
        $data = $this->model->select('tags.*');
        if ($active) {
            $data = $data->where(['tags.status' => BaseStatusEnum::PUBLISHED]);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
