<?php
namespace App;

require_once 'vendor/autoload.php';

use App\Controllers\Context;
use App\Controllers\FileParser;
use App\Services\GetExchangeRates;
use App\Services\IsFromEu;
use Exception;

try {
    // If file is with other structure ( xml, csv ) extend it using File class or replace the FileParser class
    $parser = new Context(new FileParser(new GetExchangeRates(), new IsFromEu()));
    $parser->start($argv[1]);
} catch (Exception $ex) {
    echo $ex->getMessage();
    exit(1);
}
