<?php

namespace Theme\DigitalSoftware\Http\Controllers;

use Fast\Base\Http\Responses\BaseHttpResponse;
use Fast\SeoHelper\SeoOpenGraph;
use Fast\Slug\Repositories\Interfaces\SlugInterface;
use Fast\Software\Models\Category;
use Fast\Software\Repositories\Interfaces\CategoryInterface;
use Fast\Theme\Http\Controllers\PublicController;
use Illuminate\Support\Str;
use SeoHelper;
use SlugHelper;
use Theme;
class SoftwareCategoryController extends PublicController
{
    /**
     * @param  string  $key
     * @param  \Fast\Slug\Repositories\Interfaces\SlugInterface  $slugRepository
     * @param  \Fast\Software\Repositories\Interfaces\CategoryInterface  $categoryRepository
     *
     * @return BaseHttpResponse|\Response
     */
    public function getSoftware(string $key, SlugInterface $slugRepository, CategoryInterface $categoryRepository)
    {
        $slug = $slugRepository->getFirstBy(['slugs.key' => $key, 'prefix' => SlugHelper::getPrefix(Category::class)]);

        if (!$slug) {
            abort(404);
        }

        $softwares = $categoryRepository->getFirstBy([
              'id' => $slug->reference_id,
          ], ['*'], ['softwares']);

        if (!$softwares) {
            abort(404);
        }

        SeoHelper::setTitle($softwares->name)->setDescription(Str::words($softwares->description, 120));

        $meta = new SeoOpenGraph;
        if ($softwares->image) {
            $meta->setImage(get_image_url($softwares->image));
        }
        $meta->setDescription($softwares->description);
        $meta->setUrl(route('public.list-cat', $slug->key));
        $meta->setTitle($softwares->name);
        $meta->setType('article');

        SeoHelper::setSeoOpenGraph($meta);

        Theme::breadcrumb()
            ->add(__('Home'), url('/'))
            ->add($softwares->name, route('public.list-cat', $slug));
        do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, SOFTWARE_MODULE_SCREEN_NAME, $softwares);
        return Theme::scope('software-categories', ['softwares' => $softwares->softwares])->render();
    }

    /**
     * @param BaseHttpResponse $response
     * @param null $key
     * @return BaseHttpResponse|\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getView(BaseHttpResponse $response, $key = null)
    {
        return parent::getView($response, $key);
    }

    /**
     * @return mixed
     */
    public function getSiteMap()
    {
        return parent::getSiteMap();
    }
}
