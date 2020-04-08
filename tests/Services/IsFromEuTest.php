<?php declare(strict_types=1);

namespace Test\Services;

use PHPUnit\Framework\TestCase;
use App\Services\IsFromEu;
use stdClass;

final class IsFromEuTest extends TestCase
{
    public function testIsNOTFromEu()
    {
        $usd = new stdClass();
        $usd->currency = 'USD';
        $usd->bin = '41417360';

        $bin = new IsFromEu();
        $this->assertEquals(false, $bin->check($usd));
    }

    public function testIsFromEu()
    {
        $row = new stdClass();
        $row->currency = 'GBP';
        $row->bin = '45717360';

        $bin = new IsFromEu();
        $this->assertEquals(true, $bin->check($row));
    }
}