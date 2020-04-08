<?php declare(strict_types=1);

namespace App\Services;

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
        if($row->currency == "EUR")
            return 0;

        $client = new GuzzleHttp\Client();
        $res = json_decode($client->request('GET', 'https://api.exchangeratesapi.io/latest/')->getBody()->getContents(), true);
        if(!empty($res['rates'][$row->currency]))
            return $res['rates'][$row->currency];

        throw new Exceptions\GetRateException("Not find " . serialize($row));
    }

}