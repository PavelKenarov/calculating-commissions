<?php
namespace App\Controllers;

use App\Services\GetExchangeRates;
use App\Services\IsFromEu;
use JsonMachine\JsonMachine;
use App\Exceptions;
use function JsonMachine\objects;

class FileParser extends File implements parser
{
    /**
     * @var int
     */
    const SCALE = 12;

    /**
     * @var GetExchangeRates
     */
    private $rates;

    /**
     * @var IsFromEu
     */
    private $bin;

    /**
     * @param $rates GetExchangeRates
     * @param $bin IsFromEu
     */
    public function __construct($rates, $bin)
    {
        $this->rates = $rates;
        $this->bin   = $bin;

        parent::__construct();
    }

    /**
     * @param string $file
     * @throws Exceptions\FileRowException
     * @throws Exceptions\GetBinException
     * @throws Exceptions\GetRateException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function doCalculations($file)
    {
        foreach (objects(JsonMachine::fromFile($file)) as $object)
        {
            $this->output($object);
        }
    }

    /**
     * @param object $object
     * @throws Exceptions\FileRowException
     * @throws Exceptions\GetBinException
     * @throws Exceptions\GetRateException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function output($object)
    {
        $this->validateObject($object);
        return $this->calculateAndPrint($object);
    }

    /**
     * @param object $object
     * @throws Exceptions\GetBinException
     * @throws Exceptions\GetRateException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function calculateAndPrint($object)
    {
        $rate = $this->rates->getCurrencyRate($object);
        if (!empty($rate)) {
            $object->amount = bcdiv($object->amount, $rate, self::SCALE);
        }

        return number_format(bcmul($object->amount, ($this->bin->check($object) ? 0.01 : 0.02), self::SCALE), 2);
    }

    /**
     * @param object $object
     * @throws Exceptions\FileRowException
     * @return void
     */
    public function validateObject($object)
    {
        if(empty($object->bin) || empty($object->amount) || empty($object->currency))
            throw new Exceptions\FileRowException("" . serialize($object));

        if(!preg_match('/^[A-Z]{3}$/', $object->currency) )
            throw new Exceptions\FileRowException("Invalid currency on row " . serialize($object));

    }

}



