<?php

/**
 * Created by PhpStorm.
 * User: djockey
 * Date: 10.11.18
 */

Route::group(['module' => 'Weather', 'middleware' => ['web', 'auth'],
    'namespace' => 'App\Modules\Weather\Controllers', 'as' => 'weather'], function() {
        Route::get('weather', ['uses' => 'WeatherController@index']);
});
