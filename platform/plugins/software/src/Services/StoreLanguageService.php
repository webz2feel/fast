<?php

namespace Fast\Software\Services;

use Fast\Software\Models\Software;
use Fast\Software\Services\Abstracts\StoreLanguageServiceAbstract;
use Illuminate\Http\Request;

class StoreLanguageService extends StoreLanguageServiceAbstract
{

    /**
     * @param Request $request
     * @param Software $software
     *
     * @return mixed|void
     */
    public function execute(Request $request, Software $software)
    {
        $languages = $request->input('languages');
        $software->languages()->detach();
        if (!empty($languages)) {
            foreach ($languages as $language) {
                $software->languages()->attach($language);
            }
        }
    }
}
