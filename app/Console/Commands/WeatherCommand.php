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
        $result = call_user_func([new $this->apiClass, 'load'], $this->params)
            ->resultRequestApi;

        $model = new Weather;

        $this->currentlyUpdate($result->currently, $model, $result);
        $this->dailyUpdate($result->daily->data, $model, $result);
    }

    /**
     * @param $data
     */
    public function currentlyUpdate($data, $model, $resultApi)
    {
        Weather::truncate();

        return $this->dailyUpdate([$data], $model, $resultApi);
    }

    /**
     * @param $data
     * @param $model
     * @param $resultApi
     * @param int $i
     */
    public function dailyUpdate($data, $model, $resultApi, $i = 1)
    {
        foreach ($data as $item) {
            $record[$i] = clone $model;
            $record[$i]->fill((array)$item);
            $record[$i]->apiClass = $this->apiClass;
            $record[$i]->locationName = $resultApi->locationName;
            $record[$i]->location = implode(',', [
                $resultApi->latitude,
                $resultApi->longitude
            ]);
            if(isset($item->temperatureMax)) {
                $record[$i]->temperature = $item->temperatureMax;
                $record[$i]->temperatureMin = $item->temperatureMin;
            }

            $record[$i]->save();
            dump('Good!'); $i++;
        }
    }
}
