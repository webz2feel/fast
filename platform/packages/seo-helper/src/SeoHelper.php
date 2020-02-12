<?php

namespace Fast\SeoHelper;

use Fast\SeoHelper\Contracts\SeoHelperContract;
use Fast\SeoHelper\Contracts\SeoMetaContract;
use Fast\SeoHelper\Contracts\SeoOpenGraphContract;
use Fast\SeoHelper\Contracts\SeoTwitterContract;
use Exception;

class SeoHelper implements SeoHelperContract
{
    /**
     * The SeoMeta instance.
     *
     * @var \Fast\SeoHelper\Contracts\SeoMetaContract
     */
    private $seoMeta;

    /**
     * The SeoOpenGraph instance.
     *
     * @var \Fast\SeoHelper\Contracts\SeoOpenGraphContract
     */
    private $seoOpenGraph;

    /**
     * The SeoTwitter instance.
     *
     * @var \Fast\SeoHelper\Contracts\SeoTwitterContract
     */
    private $seoTwitter;

    /**
     * Make SeoHelper instance.
     *
     * @param  \Fast\SeoHelper\Contracts\SeoMetaContract $seoMeta
     * @param  \Fast\SeoHelper\Contracts\SeoOpenGraphContract $seoOpenGraph
     * @param  \Fast\SeoHelper\Contracts\SeoTwitterContract $seoTwitter
     */
    public function __construct(
        SeoMetaContract $seoMeta,
        SeoOpenGraphContract $seoOpenGraph,
        SeoTwitterContract $seoTwitter
    ) {
        $this->setSeoMeta($seoMeta);
        $this->setSeoOpenGraph($seoOpenGraph);
        $this->setSeoTwitter($seoTwitter);
        $this->openGraph()->addProperty('type', 'website');
    }

    /**
     * Get SeoMeta instance.
     *
     * @return \Fast\SeoHelper\Contracts\SeoMetaContract
     */
    public function meta()
    {
        return $this->seoMeta;
    }

    /**
     * Set SeoMeta instance.
     *
     * @param  \Fast\SeoHelper\Contracts\SeoMetaContract $seoMeta
     *
     * @return \Fast\SeoHelper\SeoHelper
     */
    public function setSeoMeta(SeoMetaContract $seoMeta)
    {
        $this->seoMeta = $seoMeta;

        return $this;
    }

    /**
     * Get SeoOpenGraph instance.
     *
     * @return \Fast\SeoHelper\Contracts\SeoOpenGraphContract
     */
    public function openGraph()
    {
        return $this->seoOpenGraph;
    }

    /**
     * Get SeoOpenGraph instance.
     *
     * @param  \Fast\SeoHelper\Contracts\SeoOpenGraphContract $seoOpenGraph
     *
     * @return \Fast\SeoHelper\SeoHelper
     */
    public function setSeoOpenGraph(SeoOpenGraphContract $seoOpenGraph)
    {
        $this->seoOpenGraph = $seoOpenGraph;

        return $this;
    }

    /**
     * Get SeoTwitter instance.
     *
     * @return \Fast\SeoHelper\Contracts\SeoTwitterContract
     */
    public function twitter()
    {
        return $this->seoTwitter;
    }

    /**
     * Set SeoTwitter instance.
     *
     * @param  \Fast\SeoHelper\Contracts\SeoTwitterContract $seoTwitter
     *
     * @return \Fast\SeoHelper\SeoHelper
     */
    public function setSeoTwitter(SeoTwitterContract $seoTwitter)
    {
        $this->seoTwitter = $seoTwitter;

        return $this;
    }

    /**
     * Set title.
     *
     * @param  string $title
     * @param  string|null $siteName
     * @param  string|null $separator
     *
     * @return \Fast\SeoHelper\SeoHelper
     */
    public function setTitle($title, $siteName = null, $separator = null)
    {
        $this->meta()->setTitle($title, $siteName, $separator);
        $this->openGraph()->setTitle($title);
        $this->openGraph()->setSiteName($siteName);
        $this->twitter()->setTitle($title);

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->meta()->getTitle();
    }

    /**
     * Set description.
     *
     * @param  string $description
     *
     * @return \Fast\SeoHelper\Contracts\SeoHelperContract
     */
    public function setDescription($description)
    {
        $this->meta()->setDescription($description);
        $this->openGraph()->setDescription($description);
        $this->twitter()->setDescription($description);

        return $this;
    }

    /**
     * Render all seo tags.
     *
     * @return string
     */
    public function render()
    {
        return implode(PHP_EOL, array_filter([
            $this->meta()->render(),
            $this->openGraph()->render(),
            $this->twitter()->render(),
        ]));
    }

    /**
     * Render the tag.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @param $screen
     * @param \Illuminate\Http\Request $request
     * @param $object
     * @return bool
     *
     */
    public function saveMetaData($screen, $request, $object)
    {
        if (in_array(get_class($object), config('packages.seo-helper.general.supported', []))) {
            try {
                if (empty($request->input('seo_meta'))) {
                    delete_meta_data($object, 'seo_meta');
                    return false;
                }
                save_meta_data($object, 'seo_meta', $request->input('seo_meta'));
                return true;
            } catch (Exception $ex) {
                return false;
            }
        }
        return false;
    }

    /**
     * @param $screen
     * @param $object
     * @return bool
     */
    public function deleteMetaData($screen, $object)
    {
        try {
            if (in_array(get_class($object), config('packages.seo-helper.general.supported', []))) {
                delete_meta_data($object, 'seo_meta');
            }
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * @param string | array $model
     * @return $this
     */
    public function registerModule($model)
    {
        if (!is_array($model)) {
            $model = [$model];
        }
        config([
            'packages.seo-helper.general.supported' => array_merge(config('packages.seo-helper.general.supported', []),
                $model),
        ]);
        return $this;
    }
}
