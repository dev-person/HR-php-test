<?php

/**
 * Created by PhpStorm.
 * User: djockey
 * Date: 10.11.18
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\Weather\Models\Weather;

class WeatherCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновление погоды';

    /*** @var string */
    protected $apiClass;

    /** @var array|mixed  */
    public $params = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->params = config('modules.weather');
        $this->apiClass = $this->params['api-class'];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $result = call_user_func([new $this->apiClass, 'load'], $this->params)->resultRequestApi;

        foreach ($result->daily->data as $data) {
            $model = new Weather;
            $model->fill((array)$data);
            $model->apiClass = $this->apiClass;
            $model->location = implode(',', [
                $result->latitude,
                $result->longitude
            ]);

            $validator = \Validator::make(
                $model->getAttributes(),
                $model->rules()
            );

            if ($validator->fails()) {
                foreach (json_decode($validator->messages()) as $error) {
                    dump($error);
                }
            } else {
                $model->save();
                dump('save record');
            }
        }
    }
}
