<?php

namespace Fast\Software\Services;

use Fast\Base\Events\CreatedContentEvent;
use Fast\Software\Models\Software;
use Fast\Software\Services\Abstracts\StoreTagServiceAbstract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreTagService extends StoreTagServiceAbstract
{

    /**
     * @param Request $request
     * @param Software $software
     *
     * @return mixed|void
     */
    public function execute(Request $request, Software $software)
    {
        $tags = $software->tags->pluck('name')->all();

        if (implode(',', $tags) !== $request->input('tag')) {
            $software->tags()->detach();
            $tagInputs = explode(',', $request->input('tag'));
            foreach ($tagInputs as $tagName) {

                if (!trim($tagName)) {
                    continue;
                }

                $tag = $this->tagRepository->getFirstBy(['name' => $tagName]);

                if ($tag === null && !empty($tagName)) {
                    $tag = $this->tagRepository->createOrUpdate([
                        'name'      => $tagName,
                        'author_id' => Auth::user()->getKey(),
                    ]);

                    $request->merge(['slug' => $tagName]);

                    event(new CreatedContentEvent(TAG_MODULE_SCREEN_NAME, $request, $tag));
                }

                if (!empty($tag)) {
                    $software->tags()->attach($tag->id);
                }
            }
        }
    }
}
