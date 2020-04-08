<?php declare(strict_types=1);

namespace App\Services;

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
        $res = json_decode($client->request('GET', 'https://lookup.binlist.net/' . $object->bin)->getBody()->getContents());
        if(!empty($res->country->alpha2))
            return (in_array($res->country->alpha2, array('AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'EL', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK')));

        throw new Exceptions\GetBinException("Not find2 " . serialize($object));
    }

}