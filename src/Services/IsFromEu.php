<?php declare(strict_types=1);

namespace App\Services;

use App\AppConfig;
use GuzzleHttp;
use App\Exceptions;

class IsFromEu
{
    /**
     * @param $object
     * @return bool
     * @throws Exceptions\GetBinException
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function check($object)
    {
        $client = new GuzzleHttp\Client();
        $res = json_decode($client->request('GET', AppConfig::$BIN_URL . $object->bin)->getBody()->getContents());
        if(!empty($res->country->alpha2))
            return (in_array($res->country->alpha2, AppConfig::$EU_COUNTRIES));

        throw new Exceptions\GetBinException(AppConfig::$BIN_EXCEPTION . serialize($object));
    }

}