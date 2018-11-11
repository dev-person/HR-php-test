<?php

/**
 *	Weather Helper  
 */

    function timeHelper($time, $param)
    {
        switch ($param) {
            case 'day-and-week':
                return trans('weather.' . date('D', $time))
                    . date(' d', $time);
                break;
            case 'day-and-weekFull':
                return trans('weather.' . date('l', $time))
                    . date(' d', $time);
                break;
        }
    }

    function getWeatherCurrentBar()
    {
            $result = \App\Modules\Weather\Models\Weather::where([
                'location' => config('modules.weather.location'),
                'apiClass' => config('modules.weather.api-class'),
                'current' => true
            ])->first();

            return  implode(' ', [
                $result->locationName,
                $result->temperature,
                '°C'
            ]);
    }