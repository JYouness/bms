<?php
    $baseurl = Config::get('empower::baseurl');

    Route::group(array('before' => 'auth|magicaurp', 'prefix' => $baseurl), function () {
        Route::resource('series', 'Sorora\\Bms\\Controllers\\SeriesController');
        Route::resource('posts', 'Sorora\\Bms\\Controllers\\PostsController');
    });

    Route::group(array('prefix' => Config::get('bms::prefix')), function () {
        Route::get('{slug}', array('as' => 'blog.post', 'uses' => 'Sorora\\Bms\\Controllers\\BlogController@post'));
        Route::get('category/{slug}', array('as' => 'blog.category', 'uses' => 'Sorora\\Bms\\Controllers\\BlogController@category'));
    });