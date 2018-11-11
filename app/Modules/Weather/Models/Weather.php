<?php

namespace App\Modules\Weather\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model {

    protected $fillable = [
        'summary', 'icon', 'windSpeed', 'precipType',
        'locationName', 'temperature', 'time',
        'current', 'humidity'
    ];

    public $timestamps = false;

    public static function boot()
    {
        self::creating(function($model){
            $model->temperature = ($model->temperature - 32) / 1.8;
            $model->temperatureMin = ($model->temperatureMin - 32) / 1.8;
        });

        self::updating(function($model){
            $model->temperature = ($model->temperature - 32) / 1.8;
            $model->temperatureMin = ($model->temperatureMin - 32) / 1.8;
        });
    }
}
