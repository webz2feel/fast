<?php

namespace Fast\Software\Services;

use Fast\Software\Models\Software;
use Fast\Software\Services\Abstracts\StoreCategoryServiceAbstract;
use Illuminate\Http\Request;

class StoreCategoryService extends StoreCategoryServiceAbstract
{

    /**
     * @param Request $request
     * @param Software $software
     *
     * @return mixed|void
     */
    public function execute(Request $request, Software $software)
    {
        $categories = $request->input('categories');
        if (!empty($categories)) {
            $software->categories()->detach();
            foreach ($categories as $category) {
                $software->categories()->attach($category);
            }
        }
    }
}
