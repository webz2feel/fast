<?php

namespace Fast\SeoHelper\Providers;

use Fast\Base\Supports\Helper;
use Fast\Base\Traits\LoadAndPublishDataTrait;
use Fast\SeoHelper\Contracts\SeoHelperContract;
use Fast\SeoHelper\Contracts\SeoMetaContract;
use Fast\SeoHelper\Contracts\SeoOpenGraphContract;
use Fast\SeoHelper\Contracts\SeoTwitterContract;
use Fast\SeoHelper\SeoHelper;
use Fast\SeoHelper\SeoMeta;
use Fast\SeoHelper\SeoOpenGraph;
use Fast\SeoHelper\SeoTwitter;
use Illuminate\Support\ServiceProvider;

/**
 * @since 02/12/2015 14:09 PM
 */
class SeoHelperServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(SeoMetaContract::class, SeoMeta::class);
        $this->app->bind(SeoHelperContract::class, SeoHelper::class);
        $this->app->bind(SeoOpenGraphContract::class, SeoOpenGraph::class);
        $this->app->bind(SeoTwitterContract::class, SeoTwitter::class);

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('packages/seo-helper')
            ->loadAndPublishConfigurations(['general'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets();

        $this->app->register(HookServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
    }
}
