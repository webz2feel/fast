<?php


namespace Fast\Software\Repositories\Eloquent;

use Fast\Base\Enums\BaseStatusEnum;
use Fast\Support\Repositories\Eloquent\RepositoriesAbstract;
use Fast\Software\Repositories\Interfaces\SoftwareInterface;
use Eloquent;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
class SoftwareRepository extends RepositoriesAbstract implements SoftwareInterface
{
    /**
     * {@inheritdoc}
     */
    public function getFeatured($limit = 5)
    {
        $data = $this->model
            ->where([
                        'softwares.status'      => BaseStatusEnum::PUBLISHED,
                        'softwares.is_featured' => 1,
                    ])
            ->limit($limit)
            ->with('slugable')
            ->orderBy('softwares.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getListSoftwareNonInList(array $selected = [], $limit = 7)
    {
        $data = $this->model
            ->where('softwares.status', '=', BaseStatusEnum::PUBLISHED)
            ->whereNotIn('softwares.id', $selected)
            ->limit($limit)
            ->with('slugable')
            ->orderBy('softwares.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getRelated($id, $limit = 3)
    {
        $data = $this->model
            ->where('softwares.status', '=', BaseStatusEnum::PUBLISHED)
            ->where('softwares.id', '!=', $id)
            ->limit($limit)
            ->with('slugable')
            ->orderBy('softwares.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getByCategory($categoryId, $paginate = 12, $limit = 0)
    {
        if (!is_array($categoryId)) {
            $categoryId = [$categoryId];
        }

        $data = $this->model
            ->where('softwares.status', '=', BaseStatusEnum::PUBLISHED)
            ->join('post_categories', 'post_categories.post_id', '=', 'softwares.id')
            ->join('categories', 'post_categories.category_id', '=', 'categories.id')
            ->whereIn('post_categories.category_id', $categoryId)
            ->select('softwares.*')
            ->distinct()
            ->with('slugable')
            ->orderBy('softwares.created_at', 'desc');

        if ($paginate != 0) {
            return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
        }

        return $this->applyBeforeExecuteQuery($data)->limit($limit)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getByUserId($authorId, $paginate = 6)
    {
        $data = $this->model
            ->where([
                        'softwares.status'    => BaseStatusEnum::PUBLISHED,
                        'softwares.author_id' => $authorId,
                    ])
            ->with('slugable')
            ->select('softwares.*')
            ->orderBy('softwares.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
    }

    /**
     * {@inheritdoc}
     */
    public function getDataSiteMap()
    {
        $data = $this->model
            ->with('slugable')
            ->where('softwares.status', '=', BaseStatusEnum::PUBLISHED)
            ->select('softwares.*')
            ->orderBy('softwares.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getByTag($tag, $paginate = 12)
    {
        $data = $this->model
            ->with('slugable')
            ->where('softwares.status', '=', BaseStatusEnum::PUBLISHED)
            ->whereHas('tags', function ($query) use ($tag) {
                /**
                 * @var Builder $query
                 */
                $query->where('tags.id', $tag);
            })
            ->select('softwares.*')
            ->orderBy('softwares.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
    }

    /**
     * {@inheritdoc}
     */
    public function getRecentSoftwares($limit = 5, $categoryId = 0)
    {
        $softwares = $this->model->where(['softwares.status' => BaseStatusEnum::PUBLISHED]);

        if ($categoryId != 0) {
            $softwares = $softwares->join('post_categories', 'post_categories.post_id', '=', 'softwares.id')
                ->where('post_categories.category_id', '=', $categoryId);
        }

        $data = $softwares->limit($limit)
            ->with('slugable')
            ->select('softwares.*')
            ->orderBy('softwares.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getSearch($query, $limit = 10, $paginate = 10)
    {
        $softwares = $this->model->with('slugable')->where('status', BaseStatusEnum::PUBLISHED);
        foreach (explode(' ', $query) as $term) {
            $softwares = $softwares->where('name', 'LIKE', '%' . $term . '%');
        }

        $data = $softwares->select('softwares.*')
            ->orderBy('softwares.created_at', 'desc');

        if ($limit) {
            $data = $data->limit($limit);
        }

        if ($paginate) {
            return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllSoftwares($perPage = 12, $active = true)
    {
        $data = $this->model->select('softwares.*')
            ->with('slugable')
            ->orderBy('softwares.created_at', 'desc');

        if ($active) {
            $data = $data->where('softwares.status', BaseStatusEnum::PUBLISHED);
        }

        return $this->applyBeforeExecuteQuery($data)->paginate($perPage);
    }

    /**
     * {@inheritdoc}
     */
    public function getPopularSoftwares($limit, array $args = [])
    {
        $data = $this->model
            ->with('slugable')
            ->orderBy('softwares.views', 'DESC')
            ->select('softwares.*')
            ->where('softwares.status', BaseStatusEnum::PUBLISHED)
            ->limit($limit);

        if (!empty(Arr::get($args, 'where'))) {
            $data = $data->where($args['where']);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getRelatedCategoryIds($model)
    {
        $model = $model instanceof Eloquent ? $model : $this->findOrFail($model);

        try {
            return $model->categories()->allRelatedIds()->toArray();
        } catch (Exception $exception) {
            return [];
        }
    }
}
