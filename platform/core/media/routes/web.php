<?php

Route::group(['namespace' => 'Fast\Media\Http\Controllers', 'middleware' => 'web'], function () {
    Route::group(['prefix' => config('core.base.general.admin_dir'), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'media', 'as' => 'media.', 'permission' => 'media.index'], function () {
            Route::get('', [
                'as'   => 'index',
                'uses' => 'MediaController@getMedia',
            ]);

            Route::get('popup', [
                'as'   => 'popup',
                'uses' => 'MediaController@getPopup',
            ]);

            Route::get('list', [
                'as'   => 'list',
                'uses' => 'MediaController@getList',
            ]);

            Route::get('quota', [
                'as'   => 'quota',
                'uses' => 'MediaController@getQuota',
            ]);

            Route::get('breadcrumbs', [
                'as'   => 'breadcrumbs',
                'uses' => 'MediaController@getBreadcrumbs',
            ]);

            Route::post('global-actions', [
                'as'   => 'global_actions',
                'uses' => 'MediaController@postGlobalActions',
            ]);

            Route::get('download', [
                'as'   => 'download',
                'uses' => 'MediaController@download',
            ]);

            Route::group(['prefix' => 'files'], function () {
                Route::post('upload', [
                    'as'   => 'files.upload',
                    'uses' => 'MediaFileController@postUpload',
                ]);

                Route::post('upload-from-editor', [
                    'as'   => 'files.upload.from.editor',
                    'uses' => 'MediaFileController@postUploadFromEditor',
                ]);

                Route::post('add-external-service', [
                    'as'   => 'files.add_external_service',
                    'uses' => 'MediaFileController@postAddExternalService',
                ]);
            });

            Route::group(['prefix' => 'folders'], function () {
                Route::post('create', [
                    'as'   => 'folders.create',
                    'uses' => 'MediaFolderController@store',
                ]);
            });
        });
    });
});
