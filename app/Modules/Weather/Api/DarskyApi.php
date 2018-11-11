<?php namespace App\Modules\Weather\Api;

/**
 * Created by PhpStorm.
 * User: djockey
 * Date: 10.11.18
 */
final class DarskyApi implements IWeatherApi
{
    /** @var string */
    protected $apiUrl = 'https://api.darksky.net/forecast';
    /** @var string  */
    protected $apiName = 'Dark Sky API';
    /** @var array  */
    protected $initializedParams = [];
    /** @var  mixed */
    public $resultRequestApi, $geocodeData;

    /**
     * @param $params
     * @return mixed
     * @throws \Exception
     */
    public static function load($params)
    {
        if (!empty($params)) {
            if (isset($params['api-class'])) {
                if (class_exists($params['api-class'])) {
                    return call_user_func([new $params['api-class'], 'init'], $params);
                } else {
                    throw new \Exception("Class {$params['api-class']} is not exist", 500);
                }
            } else {
                throw new \Exception("Params \"api-class\" is not filled", 500);
            }
        } else {
            throw new \Exception("Params is empty!", 500);
        }
    }

    /**
     * @param $params
     * @return $this
     */
    public function init($params)
    {
        $this->initializedParams = $params;
        $this->initApi($this->initializedParams);

        return $this;
    }

    /**
     * @param array $params
     * @return array|mixed
     */
    public function initApi($params = [])
    {
        // params API
        $buildUrl = implode('/', [
            $params['secret-key'],
            $params['location']
        ]);

        // our curl handle (initialize if required)
        static $ch = null;
        if (is_null($ch)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        }
        curl_setopt($ch, CURLOPT_URL, implode('/', [
            $this->apiUrl, $buildUrl, '?exclude=minutely,hourly,flags'
        ]));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $this->resultRequestApi = json_decode(curl_exec($ch));
        $this->resultRequestApi->locationName = $this->geocodeData()->text;
        $this->resultRequestApi->currently->current = true;
    }

    /**
     * Get data of location
     * @return mixed
     */
    public function geocodeData()
    {
        if (empty($this->geocodeData)) {
            $googleApis[] = 'http://geocode-maps.yandex.ru/1.x/?format=json&';
            $googleApis[] = 'kind=locality&';
            $googleApis[] = 'geocode=' . implode(',',
                    array_reverse(
                        explode(',', $this->initializedParams['location'])
                    )
                );

            $result = file_get_contents(
                implode('', $googleApis)
            );

            $this->geocodeData = json_decode($result)
                ->response
                ->GeoObjectCollection
                ->featureMember[0]
                ->GeoObject
                ->metaDataProperty
                ->GeocoderMetaData;
        }

        return $this->geocodeData;
    }
}