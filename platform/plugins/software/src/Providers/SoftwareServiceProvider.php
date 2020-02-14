<?php
namespace Fast\Software\Providers;

use Fast\Base\Supports\Helper;
use Fast\Base\Traits\LoadAndPublishDataTrait;
use Fast\Software\Models\Category;
use Fast\Software\Models\Compatibility;
use Fast\Software\Models\Language as SoftwareLanguage;
use Fast\Software\Models\Software;
use Fast\Software\Models\System;
use Fast\Software\Models\Tag;
use Fast\Software\Repositories\Caches\CategoryCacheDecorator;
use Fast\Software\Repositories\Caches\CompatibilityCacheDecorator;
use Fast\Software\Repositories\Caches\LanguageCacheDecorator;
use Fast\Software\Repositories\Caches\SoftwareCacheDecorator;
use Fast\Software\Repositories\Caches\SystemCacheDecorator;
use Fast\Software\Repositories\Caches\TagCacheDecorator;
use Fast\Software\Repositories\Eloquent\CategoryRepository;
use Fast\Software\Repositories\Eloquent\CompatibilityRepository;
use Fast\Software\Repositories\Eloquent\LanguageRepository;
use Fast\Software\Repositories\Eloquent\SoftwareRepository;
use Fast\Software\Repositories\Eloquent\SystemRepository;
use Fast\Software\Repositories\Eloquent\TagRepository;
use Fast\Software\Repositories\Interfaces\CategoryInterface;
use Fast\Software\Repositories\Interfaces\CompatibilityInterface;
use Fast\Software\Repositories\Interfaces\LanguageInterface;
use Fast\Software\Repositories\Interfaces\SoftwareInterface;
use Fast\Software\Repositories\Interfaces\SystemInterface;
use Fast\Software\Repositories\Interfaces\TagInterface;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;
use Event;
use Language;
use SeoHelper;
use SlugHelper;
class SoftwareServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(SoftwareInterface::class, function(){
            return new SoftwareCacheDecorator(new SoftwareRepository(new Software()));
        });
        $this->app->bind(CategoryInterface::class, function() {
            return new CategoryCacheDecorator(new CategoryRepository(new Category()));
        });
        $this->app->bind(TagInterface::class, function() {
            return new TagCacheDecorator(new TagRepository(new Tag()));
        });
        $this->app->bind(SystemInterface::class, function() {
           return new SystemCacheDecorator(new SystemRepository(new System()));
        });
        $this->app->bind(CompatibilityInterface::class, function() {
            return new CompatibilityCacheDecorator(new CompatibilityRepository(new Compatibility()));
        });
        $this->app->bind(LanguageInterface::class, function() {
            return new LanguageCacheDecorator(new LanguageRepository(new SoftwareLanguage()));
        });
        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/software')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web','api'])
            ->loadMigrations()
            ->publishAssets();

        Event::listen(RouteMatched::class,
            function () {
                dashboard_menu()
                    ->registerItem([
                       'id'          => 'cms-plugins-software',
                       'priority'    => 4,
                       'parent_id'   => null,
                       'name'        => 'plugins/software::base.menu_name',
                       'icon'        => 'fa fa-cube',
                       'url'         => route('softwares.index'),
                       'permissions' => ['softwares.index'],
                    ])
                    ->registerItem([
                       'id'          => 'cms-plugins-blog-software',
                       'priority'    => 1,
                       'parent_id'   => 'cms-plugins-software',
                       'name'        => 'plugins/software::softwares.menu_name',
                       'icon'        => null,
                       'url'         => route('softwares.index'),
                       'permissions' => ['softwares.index'],
                   ])
                    ->registerItem([
                       'id'          => 'cms-plugins-software-categories',
                       'priority'    => 2,
                       'parent_id'   => 'cms-plugins-software',
                       'name'        => 'plugins/software::categories.menu_name',
                       'icon'        => null,
                       'url'         => route('software-categories.index'),
                       'permissions' => ['software-categories.index'],
                   ])
                    ->registerItem([
                       'id'          => 'cms-plugins-software-tags',
                       'priority'    => 3,
                       'parent_id'   => 'cms-plugins-software',
                       'name'        => 'plugins/software::tags.menu_name',
                       'icon'        => null,
                       'url'         => route('software-tags.index'),
                       'permissions' => ['software-tags.index'],
                   ])
                    ->registerItem([
                       'id'          => 'cms-plugins-software-system',
                       'priority'    => 4,
                       'parent_id'   => 'cms-plugins-software',
                       'name'        => 'plugins/software::system.menu_name',
                       'icon'        => null,
                       'url'         => route('systems.index'),
                       'permissions' => ['systems.index'],
                   ])
                    ->registerItem([
                       'id'          => 'cms-plugins-software-compatibility',
                       'priority'    => 3,
                       'parent_id'   => 'cms-plugins-software',
                       'name'        => 'plugins/software::compatibility.menu_name',
                       'icon'        => null,
                       'url'         => route('compatibilities.index'),
                       'permissions' => ['compatibilities.index'],
                   ])
                    ->registerItem([
                       'id'          => 'cms-plugins-software-language',
                       'priority'    => 3,
                       'parent_id'   => 'cms-plugins-software',
                       'name'        => 'plugins/software::language.menu_name',
                       'icon'        => null,
                       'url'         => route('languages.index'),
                       'permissions' => ['languages.index'],
                   ]);
        });
        $this->app->booted(function () {
            $models = [Software::class, Category::class, Tag::class, System::class, Compatibility::class, SoftwareLanguage::class];

            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                Language::registerModule($models);
            }

            SlugHelper::registerModule($models);
            SlugHelper::setPrefix(Tag::class, 'tag');

            SeoHelper::registerModule($models);
        });
        if (function_exists('shortcode')) {
            view()->composer([
                                 'plugins/software::themes.software',
                                 'plugins/software::themes.category',
                                 'plugins/software::themes.tag',
                             ], function (\Fast\Shortcode\View\View $view) {
                $view->withShortcodes();
            });
        }
    }

}
