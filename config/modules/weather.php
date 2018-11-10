<?php

/**
 * Created by PhpStorm.
 * User: djockey
 * Date: 10.11.18
 * Time: 17:44
 */

return [
    /** Класс API */
    'api-class' => env('WEATHER_API_CLASS'),
    /** Секретный ключ API */
    'secret-key' => env('WEATHER_API_SECRET_KEY'),
    /** Параметры место нахождения */
    'location' => implode(',', [
        'latitude' => env('WEATHER_API_LATITUDE'),
        'longitude' => env('WEATHER_API_LONGITUDE')
    ]),
];
