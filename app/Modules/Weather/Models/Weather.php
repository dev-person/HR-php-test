<?php

namespace App\Modules\Weather\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model {

    protected $fillable = [
        'summary', 'icon', 'precipType',
        'locationName', 'temperature', 'time',
    ];

    public $timestamps = false;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'apiClass' => 'required',
            'time'  => 'required|unique:weathers',
        ];
    }
}
