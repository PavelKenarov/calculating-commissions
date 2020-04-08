<?php declare(strict_types=1);

namespace Test\Controllers;

use PHPUnit\Framework\TestCase;
use App\Services\GetExchangeRates;
use App\Services\IsFromEu;
use App\Controllers\FileParser;

final class FileParserTest extends TestCase
{
    public function testFileParser()
    {
        $fp = new FileParser(new GetExchangeRates(), new IsFromEu());
        $object = new \stdClass();
        $object->currency = 'USD';
        $object->bin = '41417360';
        $object->amount = '2590.00';
        $this->assertTrue(is_numeric($fp->output($object)));
    }
}