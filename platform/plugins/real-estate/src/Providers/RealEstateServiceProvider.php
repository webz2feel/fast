<?php

namespace Fast\RealEstate\Providers;

use Fast\RealEstate\Models\Consult;
use Fast\RealEstate\Models\Currency;
use Fast\RealEstate\Models\Category;
use Fast\RealEstate\Repositories\Caches\ConsultCacheDecorator;
use Fast\RealEstate\Repositories\Caches\CurrencyCacheDecorator;
use Fast\RealEstate\Repositories\Caches\CategoryCacheDecorator;
use Fast\RealEstate\Repositories\Eloquent\ConsultRepository;
use Fast\RealEstate\Repositories\Eloquent\CurrencyRepository;
use Fast\RealEstate\Repositories\Eloquent\CategoryRepository;
use Fast\RealEstate\Repositories\Interfaces\ConsultInterface;
use Fast\RealEstate\Repositories\Interfaces\CurrencyInterface;
use Fast\RealEstate\Models\Investor;
use Fast\RealEstate\Repositories\Caches\InvestorCacheDecorator;
use Fast\RealEstate\Repositories\Eloquent\InvestorRepository;
use Fast\RealEstate\Repositories\Interfaces\InvestorInterface;
use Fast\RealEstate\Models\Project;
use Fast\RealEstate\Models\Property;
use Fast\RealEstate\Models\Feature;
use Fast\RealEstate\Repositories\Caches\ProjectCacheDecorator;
use Fast\RealEstate\Repositories\Caches\PropertyCacheDecorator;
use Fast\RealEstate\Repositories\Caches\FeatureCacheDecorator;
use Fast\RealEstate\Repositories\Eloquent\ProjectRepository;
use Fast\RealEstate\Repositories\Eloquent\FeatureRepository;
use Fast\RealEstate\Repositories\Eloquent\PropertyRepository;
use Fast\RealEstate\Repositories\Interfaces\ProjectInterface;
use Fast\RealEstate\Repositories\Interfaces\FeatureInterface;
use Fast\RealEstate\Repositories\Interfaces\PropertyInterface;
use Fast\RealEstate\Repositories\Interfaces\CategoryInterface;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;
use Fast\Base\Supports\Helper;
use Event;
use Fast\Base\Traits\LoadAndPublishDataTrait;
use Language;
use SeoHelper;
use SlugHelper;

class RealEstateServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * @var Application
     */
    protected $app;

    public function register()
    {
        $this->app->singleton(PropertyInterface::class, function () {
            return new PropertyCacheDecorator(
                new PropertyRepository(new Property)
            );
        });

        $this->app->singleton(ProjectInterface::class, function () {
            return new ProjectCacheDecorator(
                new ProjectRepository(new Project)
            );
        });

        $this->app->singleton(FeatureInterface::class, function () {
            return new FeatureCacheDecorator(
                new FeatureRepository(new Feature)
            );
        });

        $this->app->bind(InvestorInterface::class, function () {
            return new InvestorCacheDecorator(new InvestorRepository(new Investor));
        });

        $this->app->bind(CurrencyInterface::class, function () {
            return new CurrencyCacheDecorator(
                new CurrencyRepository(new Currency)
            );
        });

        $this->app->bind(ConsultInterface::class, function () {
            return new ConsultCacheDecorator(
                new ConsultRepository(new Consult)
            );
        });

        $this->app->bind(CategoryInterface::class, function () {
            return new CategoryCacheDecorator(
                new CategoryRepository(new Category)
            );
        });


        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/real-estate')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id'          => 'cms-plugins-real-estate',
                    'priority'    => 5,
                    'parent_id'   => null,
                    'name'        => 'plugins/real-estate::real-estate.name',
                    'icon'        => 'fa fa-bed',
                    'permissions' => ['projects.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-property',
                    'priority'    => 0,
                    'parent_id'   => 'cms-plugins-real-estate',
                    'name'        => 'plugins/real-estate::property.name',
                    'icon'        => null,
                    'url'         => route('property.index'),
                    'permissions' => ['property.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-project',
                    'priority'    => 1,
                    'parent_id'   => 'cms-plugins-real-estate',
                    'name'        => 'plugins/real-estate::project.name',
                    'icon'        => null,
                    'url'         => route('project.index'),
                    'permissions' => ['project.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-re-feature',
                    'priority'    => 2,
                    'parent_id'   => 'cms-plugins-real-estate',
                    'name'        => 'plugins/real-estate::feature.name',
                    'icon'        => null,
                    'url'         => route('property_feature.index'),
                    'permissions' => ['property_feature.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-investor',
                    'priority'    => 3,
                    'parent_id'   => 'cms-plugins-real-estate',
                    'name'        => 'plugins/real-estate::investor.name',
                    'icon'        => null,
                    'url'         => route('investor.index'),
                    'permissions' => ['investor.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-real-estate-settings',
                    'priority'    => 999,
                    'parent_id'   => 'cms-plugins-real-estate',
                    'name'        => 'plugins/real-estate::real-estate.settings',
                    'icon'        => null,
                    'url'         => route('real-estate.settings'),
                    'permissions' => ['real-estate.settings'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-consult',
                    'priority'    => 6,
                    'parent_id'   => null,
                    'name'        => 'plugins/real-estate::consult.name',
                    'icon'        => 'fas fa-headset',
                    'url'         => route('consult.index'),
                    'permissions' => ['consult.index'],
                ])
                ->registerItem([
                    'id'          => 'cms-plugins-real-estate-category',
                    'priority'    => 4,
                    'parent_id'   => 'cms-plugins-real-estate',
                    'name'        => 'plugins/real-estate::category.name',
                    'icon'        => null,
                    'url'         => route('category.index'),
                    'permissions' => ['category.index'],
                ]);

        });

        $this->app->booted(function () {
            $modules = [
                Property::class,
                Project::class,
            ];

            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                Language::registerModule($modules);
                Language::registerModule([
                    Feature::class,
                    Investor::class,
                    Category::class,
                ]);
            }

            SlugHelper::registerModule($modules);
            SlugHelper::disablePreview($modules);
            SlugHelper::setPrefix(Project::class, 'projects');
            SlugHelper::setPrefix(Property::class, 'properties');

            SeoHelper::registerModule($modules);
        });

        $this->app->register(HookServiceProvider::class);
    }
}
