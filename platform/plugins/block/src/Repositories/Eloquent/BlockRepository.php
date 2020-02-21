<?php

namespace Fast\Block\Repositories\Eloquent;

use Fast\Support\Repositories\Eloquent\RepositoriesAbstract;
use Fast\Block\Repositories\Interfaces\BlockInterface;

class BlockRepository extends RepositoriesAbstract implements BlockInterface
{
    /**
     * @var string
     */
    protected $screen = BLOCK_MODULE_SCREEN_NAME;

    /**
     * @param string $name
     * @param int $id
     * @return mixed
     * @author Imran Ali
     */
    public function createSlug($name, $id)
    {
        $slug = str_slug($name);
        $index = 1;
        $baseSlug = $slug;
        while ($this->model->where('alias', $slug)->where('id', '!=', $id)->count() > 0) {
            $slug = $baseSlug . '-' . $index++;
        }

        if (empty($slug)) {
            $slug = time();
        }

        $this->resetModel();

        return $slug;
    }
}
