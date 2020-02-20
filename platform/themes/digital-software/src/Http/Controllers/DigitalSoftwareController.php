<?php

namespace Theme\DigitalSoftware\Http\Controllers;

use Fast\Base\Http\Responses\BaseHttpResponse;
use Fast\SeoHelper\SeoOpenGraph;
use Fast\Slug\Repositories\Interfaces\SlugInterface;
use Fast\Software\Models\Software;
use Fast\Software\Repositories\Interfaces\SoftwareInterface;
use Fast\Theme\Http\Controllers\PublicController;
use Illuminate\Support\Str;
use SeoHelper;
use SlugHelper;
use Theme;
class DigitalSoftwareController extends PublicController
{
    /**
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getIndex(BaseHttpResponse $response)
    {
        $softwares = get_recent_softwares(10);
        $allCategories = get_all_software_categories(['status' => 'published']);
        $featuredCat = get_featured_software_categories(6);
        return Theme::scope('index', compact('softwares', 'allCategories', 'featuredCat'))->render();
    }

    public function softwareDetail(string $key, SlugInterface $slugRepository, SoftwareInterface $softwareRepository)
    {
        $slug = $slugRepository->getFirstBy(['slugs.key' => $key, 'prefix' => SlugHelper::getPrefix(Software::class)]);

        if (!$slug) {
            abort(404);
        }

        $software = $softwareRepository->getFirstBy([
             'id' => $slug->reference_id,
         ], ['*']);

        if (!$software) {
            abort(404);
        }
        $software->views = $software->views + 1;
        $software->save();
        SeoHelper::setTitle($software->name)->setDescription(Str::words($software->description, 120));

        $meta = new SeoOpenGraph;
        if ($software->image) {
            $meta->setImage(get_image_url($software->image));
        }
        $meta->setDescription($software->description);
        $meta->setUrl(route('public.software-detail', $slug->key));
        $meta->setTitle($software->name);
        $meta->setType('article');

        SeoHelper::setSeoOpenGraph($meta);

        Theme::breadcrumb()
            ->add(__('Home'), url('/'))
            ->add($software->name, route('public.software-detail', $slug));
        do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, SOFTWARE_MODULE_SCREEN_NAME, $software);
        return Theme::scope('software-detail', ['software' => $software])->render();
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
