<?php

namespace Fast\Software\Repositories\Eloquent;

use Fast\Base\Enums\BaseStatusEnum;
use Fast\Software\Repositories\Interfaces\LanguageInterface;
use Fast\Support\Repositories\Eloquent\RepositoriesAbstract;

class LanguageRepository extends RepositoriesAbstract implements LanguageInterface
{

    /**
     * {@inheritdoc}
     */
    public function getDataSiteMap()
    {
        $data = $this->model
            ->with('slugable')
            ->where('software_languages.status', '=', BaseStatusEnum::PUBLISHED)
            ->select('software_languages.*')
            ->orderBy('software_languages.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getPopularLanguages($limit)
    {
        $data = $this->model
            ->with('slugable')
            ->orderBy('software_languages.id', 'DESC')
            ->select('software_languages.*')
            ->limit($limit);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllLanguages($active = true)
    {
        $data = $this->model->select('software_languages.*');
        if ($active) {
            $data = $data->where(['software_languages.status' => BaseStatusEnum::PUBLISHED]);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
