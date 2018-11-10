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

    public $resultRequestApi;

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
        $this->initConfiguration($this->initializedParams);
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
        curl_setopt($ch, CURLOPT_URL, implode('/', [$this->apiUrl, $buildUrl]));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $this->resultRequestApi = json_decode(curl_exec($ch));
    }

    /**
     * @param $params
     * @param array $preloadParams
     */
    public function initConfiguration($params, $preloadParams = [])
    {
        if (empty($preloadParams)) {
            foreach ($params as $param => $value) {
                //... code for reset params
            }
        } else {
            $this->resultRequestApi = array_merge(
                $this->resultRequestApi,
                $preloadParams
            );
        }
    }
}