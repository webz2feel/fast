<?php

namespace Fast\Blog\Repositories\Eloquent;

use Fast\Base\Enums\BaseStatusEnum;
use Fast\Support\Repositories\Eloquent\RepositoriesAbstract;
use Fast\Blog\Repositories\Interfaces\CategoryInterface;
use Eloquent;

class CategoryRepository extends RepositoriesAbstract implements CategoryInterface
{

    /**
     * {@inheritdoc}
     */
    public function getDataSiteMap()
    {
        $data = $this->model
            ->with('slugable')
            ->where('categories.status', '=', BaseStatusEnum::PUBLISHED)
            ->select('categories.*')
            ->orderBy('categories.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getFeaturedCategories($limit)
    {
        $data = $this->model
            ->with('slugable')
            ->where([
                'categories.status'      => BaseStatusEnum::PUBLISHED,
                'categories.is_featured' => 1,
            ])
            ->select([
                'categories.id',
                'categories.name',
                'categories.icon',
            ])
            ->orderBy('categories.order', 'asc')
            ->select('categories.*')
            ->limit($limit);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllCategories(array $condition = [])
    {
        $data = $this->model->with('slugable')->select('categories.*');
        if (!empty($condition)) {
            $data = $data->where($condition);
        }

        $data = $data->orderBy('categories.order', 'DESC');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoryById($id)
    {
        $data = $this->model->with('slugable')->where([
            'categories.id'     => $id,
            'categories.status' => BaseStatusEnum::PUBLISHED,
        ]);

        return $this->applyBeforeExecuteQuery($data, true)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function getCategories(array $select, array $orderBy)
    {
        $data = $this->model->with('slugable')->select($select);
        foreach ($orderBy as $by => $direction) {
            $data = $data->orderBy($by, $direction);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllRelatedChildrenIds($id)
    {
        if ($id instanceof Eloquent) {
            $model = $id;
        } else {
            $model = $this->getFirstBy(['categories.id' => $id]);
        }
        if (!$model) {
            return null;
        }

        $result = [];

        $children = $model->children()->select('categories.id')->get();

        foreach ($children as $child) {
            $result[] = $child->id;
            $result = array_merge($this->getAllRelatedChildrenIds($child), $result);
        }
        $this->resetModel();

        return array_unique($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getAllCategoriesWithChildren(array $condition = [], array $with = [], array $select = ['*'])
    {
        $data = $this->model
            ->where($condition)
            ->with($with)
            ->select($select);

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
