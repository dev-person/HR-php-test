<?php namespace App\Modules\Weather\Api;

/**
 * Created by PhpStorm.
 * User: djockey
 * Date: 10.11.18
 */

interface IWeatherApi
{
    /**
     * @param $params
     * @return mixed
     */
    public static function load($params);

    /**
     * @param $params
     * @return mixed
     */
    public function init($params);
}