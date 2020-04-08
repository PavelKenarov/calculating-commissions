<?php declare(strict_types=1);

namespace Test\Services;

use PHPUnit\Framework\TestCase;
use App\Services\GetExchangeRates;
use stdClass;

final class GetExchangeRatesTest extends TestCase
{
    public function testCheckIsReturnFloat()
    {
        $row = new stdClass();
        $row->currency = 'USD';

        $rate = new GetExchangeRates($row);
        $this->assertIsFloat($rate->getCurrencyRate($row));

        $row->currency = 'JPY';
        $rate = new GetExchangeRates($row);
        $this->assertIsFloat($rate->getCurrencyRate($row));
    }
}