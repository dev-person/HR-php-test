<?php

/**
 * Created by PhpStorm.
 * User: djockey
 * Date: 10.11.18
 */

namespace App\Modules\Weather\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Weather\Models\Weather;

class WeatherController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = Weather::query()->where([
            'location' => config('modules.weather.location')
        ])->all();

        return view("Weather::index")->with(['data' => $model]);
    }

}
