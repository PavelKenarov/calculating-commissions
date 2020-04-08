<?php

namespace App\Services;

use App\AppConfig;
use App\Exceptions;
use GuzzleHttp;

class GetExchangeRates
{
    /**
     * @param object $row
     * @return string
     * @throws Exceptions\GetRateException
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function getCurrencyRate($row)
    {
        if($row->currency == AppConfig::$NO_COMMISSION)
            return 0;

        $client = new GuzzleHttp\Client();
        $res = json_decode($client->request('GET', AppConfig::$RATE_URL)->getBody()->getContents(), true);
        if(!empty($res['rates'][$row->currency]))
            return $res['rates'][$row->currency];

        throw new Exceptions\GetRateException(AppConfig::$RATE_EXCEPTION . serialize($row));
    }

}