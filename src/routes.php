<?php
    $baseurl = Config::get('empower::baseurl');

    Route::group(array('before' => 'auth|magicaurp', 'prefix' => $baseurl), function () {

        Route::resource('series', 'Sorora\\Bms\\Controllers\\SeriesController');

        Route::resource('posts', 'Sorora\\Bms\\Controllers\\PostsController');

    });