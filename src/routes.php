<?php
    $baseurl = Config::get('empower::baseurl');

    Route::group(array('before' => 'auth|magicaurp', 'prefix' => $baseurl), function () {
        Route::resource('series', 'Sorora\\Bms\\Controllers\\SeriesController');
        Route::resource('posts', 'Sorora\\Bms\\Controllers\\PostsController');
    });

    Route::get(Config::get('bms::prefix'), array('as' => 'blog.index', 'uses' => 'Sorora\\Bms\\Controllers\\BlogController@index'));

    Route::group(array('prefix' => Config::get('bms::prefix')), function () {
        Route::get('categories', array('as' => 'blog.categories', 'uses' => 'Sorora\\Bms\\Controllers\\BlogController@categories'));
        Route::get('category/{slug}', array('as' => 'blog.category', 'uses' => 'Sorora\\Bms\\Controllers\\BlogController@category'));
        Route::get('tag/{slug}', array('as' => 'blog.tag', 'uses' => 'Sorora\\Bms\\Controllers\\BlogController@tag'));
        Route::get('{slug}', array('as' => 'blog.post', 'uses' => 'Sorora\\Bms\\Controllers\\BlogController@post'));
    });