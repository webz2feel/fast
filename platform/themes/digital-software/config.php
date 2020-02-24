<?php

use Fast\Software\Repositories\Interfaces\CategoryInterface;
use Fast\Theme\Theme;
return [

    /*
    |--------------------------------------------------------------------------
    | Inherit from another theme
    |--------------------------------------------------------------------------
    |
    | Set up inherit from another if the file is not exists,
    | this is work with "layouts", "partials" and "views"
    |
    | [Notice] assets cannot inherit.
    |
    */

    'inherit' => null, //default

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities
    | this is cool feature to set up a title, meta, default styles and scripts.
    |
    | [Notice] these event can be override by package config.
    |
    */

    'events' => [

        // Before event inherit from package config and the theme that call before,
        // you can use this event to set meta, breadcrumb template or anything
        // you want inheriting.
        'before' => function($theme)
        {
            // You can remove this line anytime.
        },

        // Listen on event before render a theme,
        // this event should call to assign some assets,
        // breadcrumb template.
        'beforeRenderTheme' => function(Theme $theme)
        {
            // You may use this event to set up your assets.
            // $theme->asset()->usePath()->add('core', 'core.js');
            // $theme->asset()->usePath()->add('jquery', 'vendor/jquery/jquery.min.js');
            // $theme->asset()->usePath()->add('jquery-ui', 'vendor/jqueryui/jquery-ui.min.js', ['jquery']);
            $theme->asset()->usePath()->add('fontawesome-css', 'libraries/fontawesome/css/font-awesome.min.css');
            $theme->asset()->usePath()->add('bootstrap-css', 'libraries/bootstrap/bootstrap.min.v4.css');
            $theme->asset()->usePath()->add('style-css', 'css/style.css');
            // Partial composer.
            // $theme->partialComposer('header', function($view)
            // {
            //     $view->with('auth', \Auth::user());
            // });

            $theme->composer(['index','software-categories','left-side','software-detail','search'], function($view) {
                $categories = collect([]);
                $categories = app(CategoryInterface::class)->advancedGet([
                     'condition' => [
                         'software_categories.status'      => 'published',
                         'software_categories.parent_id'   => 0,
                     ],
                 ]);
                $view->with('categories', compact('categories'));
                $topDownloads = get_top_downloads_software(7);
                $latestDownloads = get_latest_downloads_software(5);
                $view->with('topDownloads', compact('topDownloads'));
                $view->with('latestDownloads', compact('latestDownloads'));
            });
            if (function_exists('shortcode')) {
                $theme->composer(['index', 'page', 'post'], function(\Fast\Shortcode\View\View $view) {
                    $view->withShortcodes();
                });
            }
        },

        // Listen on event before render a layout,
        // this should call to assign style, script for a layout.
        'beforeRenderLayout' => [

            'default' => function($theme)
            {
                // $theme->asset()->usePath()->add('ipad', 'css/layouts/ipad.css');
            }
        ]
    ]
];
