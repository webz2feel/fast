<?php

namespace Fast\Software\Services;

use Fast\Software\Models\Software;
use Fast\Software\Services\Abstracts\StoreCompatibilityServiceAbstract;
use Illuminate\Http\Request;

class StoreCompatibilityService extends StoreCompatibilityServiceAbstract
{

    /**
     * @param Request $request
     * @param Software $software
     *
     * @return mixed|void
     */
    public function execute(Request $request, Software $software)
    {
        $compatibilities = $request->input('compatibilities');
        $software->compatibilities()->detach();
        if (!empty($compatibilities)) {
            foreach ($compatibilities as $compatibility) {
                $software->compatibilities()->attach($compatibility);
            }
        }
    }
}
