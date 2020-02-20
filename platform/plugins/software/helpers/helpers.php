<?php

use Fast\Base\Enums\BaseStatusEnum;
use Fast\Base\Supports\SortItemsWithChildrenHelper;
use Fast\Software\Repositories\Interfaces\CategoryInterface;
use Fast\Software\Repositories\Interfaces\CompatibilityInterface;
use Fast\Software\Repositories\Interfaces\LanguageInterface;
use Fast\Software\Repositories\Interfaces\SoftwareInterface;
use Fast\Software\Repositories\Interfaces\SystemInterface;
use Fast\Software\Repositories\Interfaces\TagInterface;
use Fast\Software\Supports\SoftwareFormat;
use Illuminate\Support\Arr;

if (!function_exists('get_featured_softwares')) {
    /**
     * @param $limit
     * @return mixed
     *
     */
    function get_featured_softwares($limit)
    {
        return app(SoftwareInterface::class)->getFeatured($limit);
    }
}

if (!function_exists('get_latest_softwares')) {
    /**
     * @param $limit
     * @param array $excepts
     * @return mixed
     *
     */
    function get_latest_softwares($limit, $excepts = [])
    {
        return app(SoftwareInterface::class)->getListSoftwareNonInList($excepts, $limit);
    }
}


if (!function_exists('get_related_softwares')) {
    /**
     * @param $current_slug
     * @param $limit
     * @return mixed
     *
     */
    function get_related_softwares($current_slug, $limit)
    {
        return app(SoftwareInterface::class)->getRelated($current_slug, $limit);
    }
}

if (!function_exists('get_softwares_by_category')) {
    /**
     * @param $category_id
     * @param $paginate
     * @param $limit
     * @return mixed
     *
     */
    function get_softwares_by_category($category_id, $paginate = 12, $limit = 0)
    {
        return app(SoftwareInterface::class)->getByCategory($category_id, $paginate, $limit);
    }
}

if (!function_exists('get_softwares_by_tag')) {
    /**
     * @param $slug
     * @param $paginate
     * @return mixed
     *
     */
    function get_softwares_by_tag($slug, $paginate = 12)
    {
        return app(SoftwareInterface::class)->getByTag($slug, $paginate);
    }
}

if (!function_exists('get_softwares_by_user')) {
    /**
     * @param $author_id
     * @param $paginate
     * @return mixed
     *
     */
    function get_softwares_by_user($author_id, $paginate = 12)
    {
        return app(SoftwareInterface::class)->getByUserId($author_id, $paginate);
    }
}

if (!function_exists('get_all_softwares')) {
    /**
     * @param boolean $active
     * @param int $perPage
     * @return mixed
     *
     */
    function get_all_softwares($active = true, $perPage = 12)
    {
        return app(SoftwareInterface::class)->getAllSoftwares($perPage, $active);
    }
}

if (!function_exists('get_recent_softwares')) {
    /**
     * @param $limit
     * @return mixed
     *
     */
    function get_recent_softwares($limit)
    {
        return app(SoftwareInterface::class)->getRecentSoftwares($limit);
    }
}


if (!function_exists('get_featured_software_categories')) {
    /**
     * @param $limit
     * @return mixed
     *
     */
    function get_featured_software_categories($limit)
    {
        return app(CategoryInterface::class)->getFeaturedCategories($limit);
    }
}

if (!function_exists('get_all_software_categories')) {
    /**
     * @param array $condition
     * @return mixed
     *
     */
    function get_all_software_categories(array $condition = [])
    {
        return app(CategoryInterface::class)->getAllCategories($condition);
    }
}

if (!function_exists('get_all_systems')) {
    /**
     * @param array $condition
     * @return mixed
     *
     */
    function get_all_systems(array $condition = [])
    {
        return app(SystemInterface::class)->getAllSystems($condition);
    }
}

if (!function_exists('get_all_software_languages')) {
    /**
     * @param array $condition
     * @return mixed
     *
     */
    function get_all_software_languages(array $condition = [])
    {
        return app(LanguageInterface::class)->getAllLanguages($condition);
    }
}

if (!function_exists('get_all_compatibilities')) {
    /**
     * @param array $condition
     * @return mixed
     *
     */
    function get_all_compatibilities(array $condition = [])
    {
        return app(CompatibilityInterface::class)->getAllCompatibilities($condition);
    }
}

if (!function_exists('get_all_tags')) {
    /**
     * @param boolean $active
     * @return mixed
     *
     */
    function get_all_tags($active = true)
    {
        return app(TagInterface::class)->getAllTags($active);
    }
}

if (!function_exists('get_popular_tags')) {
    /**
     * @param integer $limit
     * @return mixed
     *
     */
    function get_popular_tags($limit = 10)
    {
        return app(TagInterface::class)->getPopularTags($limit);
    }
}

if (!function_exists('get_popular_softwares')) {
    /**
     * @param integer $limit
     * @param array $args
     * @return mixed
     *
     */
    function get_popular_softwares($limit = 10, array $args = [])
    {
        return app(SoftwareInterface::class)->getPopularSoftwares($limit, $args);
    }
}

if (!function_exists('get_category_by_id')) {
    /**
     * @param integer $id
     * @return mixed
     *
     */
    function get_category_by_id($id)
    {
        return app(CategoryInterface::class)->getCategoryById($id);
    }
}

if (!function_exists('get_software_categories')) {
    /**
     * @param array $args
     * @return array|mixed
     */
    function get_software_categories(array $args = [])
    {
        $indent = Arr::get($args, 'indent', '——');

        $repo = app(CategoryInterface::class);

        $categories = $repo->getCategories(Arr::get($args, 'select', ['*']), [
            'software_categories.is_default' => 'DESC',
            'software_categories.order'      => 'ASC',
        ]);

        $categories = sort_item_with_children($categories);

        foreach ($categories as $category) {
            $indentText = '';
            $depth = (int)$category->depth;
            for ($i = 0; $i < $depth; $i++) {
                $indentText .= $indent;
            }
            $category->indent_text = $indentText;
        }

        return $categories;
    }
}

if (!function_exists('get_software_categories_with_children')) {
    /**
     * @return array
     * @throws Exception
     */
    function get_software_categories_with_children()
    {
        $categories = app(CategoryInterface::class)
            ->getAllCategoriesWithChildren(['status' => BaseStatusEnum::PUBLISHED], [], ['id', 'name', 'parent_id']);
        $sortHelper = app(SortItemsWithChildrenHelper::class);
        $sortHelper
            ->setChildrenProperty('child_cats')
            ->setItems($categories);

        return $sortHelper->sort();
    }
}

if (!function_exists('register_post_format')) {
    /**
     * @param array $formats
     * @return void
     *
     */
    function register_post_format(array $formats)
    {
        SoftwareFormat::registerSoftwareFormat($formats);
    }
}

if (!function_exists('get_post_formats')) {
    /**
     * @param bool $convert_to_list
     * @return array
     *
     */
    function get_post_formats($convert_to_list = false)
    {
        return SoftwareFormat::getSoftwareFormats($convert_to_list);
    }
}
