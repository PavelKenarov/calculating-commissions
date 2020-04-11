<?php
namespace App\Controllers;

use App\Services\GetExchangeRates;
use App\Services\IsFromEu;
use App\AppConfig;
use GuzzleHttp\Exception\GuzzleException;
use JsonMachine\JsonMachine;
use App\Exceptions;
use function JsonMachine\objects;

class FileParser extends File
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
     * @throws GuzzleException
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
     * @return string
     * @throws Exceptions\FileRowException
     * @throws Exceptions\GetBinException
     * @throws Exceptions\GetRateException
     * @throws GuzzleException
     */
    public function output($object)
    {
        $this->validateObject($object);
        return $this->calculateAndPrint($object);
    }

    /**
     * @param object $object
     * @return string
     * @throws Exceptions\GetBinException
     * @throws Exceptions\GetRateException
     * @throws GuzzleException
     */
    public function calculateAndPrint($object)
    {
        $rate = $this->rates->getCurrencyRate($object);
        if (!empty($rate)) {
            $object->amount = bcdiv($object->amount, $rate, self::SCALE);
        }

        $r = number_format(bcmul($object->amount, ($this->bin->check($object) ? AppConfig::$EU_TAX : AppConfig::$TAX), self::SCALE), AppConfig::$DECIMALS);

        echo $r . "\n";
        return $r;
    }

    /**
     * @param object $object
     * @throws Exceptions\FileRowException
     * @return void
     */
    public function validateObject($object)
    {
        if(empty($object->bin) || empty($object->amount) || empty($object->currency))
            throw new Exceptions\FileRowException(AppConfig::$NO_FILE . serialize($object));

        if(!preg_match(AppConfig::$CURRENCY_REGEXP, $object->currency) )
            throw new Exceptions\FileRowException(AppConfig::$CURRENCY_PR . serialize($object));

    }

}
