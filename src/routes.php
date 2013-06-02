<?php
    $baseurl = Config::get('empower::baseurl');

    Route::group(array('before' => 'auth|magicaurp', 'prefix' => $baseurl), function () {
        Route::resource('series', 'Sorora\\Bms\\Controllers\\SeriesController');
        Route::resource('posts', 'Sorora\\Bms\\Controllers\\PostsController');
    });

    Route::group(array('prefix' => Config::get('bms::prefix')), function () {
        $prefix = Config::get('bms::prefix');
        $prefix = ($prefix) ? Config::get('bms::prefix').'.' : null;
        Route::get('{slug}', array('as' => $prefix.'blog.show', 'uses' => 'Sorora\\Bms\\Controllers\\BlogController@show'));
    });