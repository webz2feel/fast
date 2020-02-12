<?php

namespace Fast\Widget\Repositories\Eloquent;

use Fast\Support\Repositories\Eloquent\RepositoriesAbstract;
use Fast\Widget\Repositories\Interfaces\WidgetInterface;

class WidgetRepository extends RepositoriesAbstract implements WidgetInterface
{
    /**
     * {@inheritdoc}
     */
    public function getByTheme($theme)
    {
        $data = $this->model->where('theme', '=', $theme)->get();
        $this->resetModel();

        return $data;
    }
}
