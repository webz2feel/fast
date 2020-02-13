<?php

Route::group([
    'middleware' => 'api',
    'prefix'     => 'api/v1',
    'namespace'  => 'Fast\Software\Http\Controllers\API',
], function () {

    Route::get('search', 'SoftwareController@getSearch')->name('public.api.search');
    Route::get('posts', 'SoftwareController@index');
    Route::get('software-categories', 'CategoryController@index');
    Route::get('software-tags', 'TagController@index');

});
