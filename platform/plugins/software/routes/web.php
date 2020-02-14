<?php

Route::group(['namespace' => 'Fast\Software\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => config('core.base.general.admin_dir'), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'softwares', 'as' => 'softwares.'], function () {
            Route::resource('', 'SoftwareController')->parameters(['' => 'software']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'SoftwareController@deletes',
                'permission' => 'softwares.destroy',
            ]);

            Route::get('widgets/recent-softwares', [
                'as'         => 'widget.recent-softwares',
                'uses'       => 'SoftwareController@getWidgetRecentSoftwares',
                'permission' => 'softwares.index',
            ]);
        });

        Route::group(['prefix' => 'software-categories', 'as' => 'software-categories.'], function () {
            Route::resource('', 'CategoryController')->parameters(['' => 'category']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'CategoryController@deletes',
                'permission' => 'software-categories.destroy',
            ]);
        });

        Route::group(['prefix' => 'software-tags', 'as' => 'software-tags.'], function () {
            Route::resource('', 'TagController')->parameters(['' => 'tag']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'TagController@deletes',
                'permission' => 'software-tags.destroy',
            ]);

            Route::get('all', [
                'as'         => 'all',
                'uses'       => 'TagController@getAllTags',
                'permission' => 'software-tags.index',
            ]);
        });
        Route::group(['prefix' => 'software-system', 'as' => 'systems.'], function () {
            Route::resource('', 'SystemController')->parameters(['' => 'system']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'SystemController@deletes',
                'permission' => 'systems.destroy',
            ]);

            Route::get('all', [
                'as'         => 'all',
                'uses'       => 'SystemController@getAllSystems',
                'permission' => 'systems.index',
            ]);
        });
        Route::group(['prefix' => 'software-compatibility', 'as' => 'compatibilities.'], function () {
            Route::resource('', 'CompatibilityController')->parameters(['' => 'compatibility']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'CompatibilityController@deletes',
                'permission' => 'compatibilities.destroy',
            ]);

            Route::get('all', [
                'as'         => 'all',
                'uses'       => 'CompatibilityController@getAllCompatibilities',
                'permission' => 'compatibilities.index',
            ]);
        });
        Route::group(['prefix' => 'software-language', 'as' => 'languages.'], function () {
            Route::resource('', 'LanguageController')->parameters(['' => 'language']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'LanguageController@deletes',
                'permission' => 'languages.destroy',
            ]);

            Route::get('all', [
                'as'         => 'all',
                'uses'       => 'LanguageController@getAllLanguages',
                'permission' => 'languages.index',
            ]);
        });
    });

    if (defined('THEME_MODULE_SCREEN_NAME')) {
        Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
            Route::get('search', [
                'as'   => 'public.search',
                'uses' => 'PublicController@getSearch',
            ]);

            Route::get('tag/{slug}', [
                'as'   => 'public.tag',
                'uses' => 'PublicController@getTag',
            ]);
        });
    }
});
