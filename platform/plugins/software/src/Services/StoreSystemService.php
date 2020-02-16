<?php

namespace Fast\Software\Services;

use Fast\Software\Models\Software;
use Fast\Software\Services\Abstracts\StoreSystemServiceAbstract;
use Illuminate\Http\Request;

class StoreSystemService extends StoreSystemServiceAbstract
{

    /**
     * @param Request $request
     * @param Software $software
     *
     * @return mixed|void
     */
    public function execute(Request $request, Software $software)
    {
        $systems = $request->input('systems');
        $software->systems()->detach();
        if (!empty($systems)) {
            foreach ($systems as $system) {
                $software->systems()->attach($system);
            }
        }
    }
}
