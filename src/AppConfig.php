<?php
namespace App;

class AppConfig
{
    // class FileParser
    public static $EU_TAX          = 0.01;
    static $TAX             = 0.02;
    static $NO_FILE         = "Invalid file row ";
    static $CURRENCY_PR     = "Invalid currency on row ";
    static $CURRENCY_REGEXP = '/^[A-Z]{3}$/';
    static $DECIMALS        = 2; // number_format parameter at final result - set the number of decimal points.

    // class IsFromEu
    static $BIN_URL         = 'https://lookup.binlist.net/';
    static $EU_COUNTRIES    = array('AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'EL', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK');
    static $BIN_EXCEPTION   = "Not find country code from bin number on row ";

    // class GetExchangeRates
    static $NO_COMMISSION   = 'EUR'; // Has no commission added for this currency
    static $RATE_URL        = 'https://api.exchangeratesapi.io/latest/';
    static $RATE_EXCEPTION  = "Not find rate on row ";

    // class FileMissedException
    static $MISSING_FILE    = "Not found transaction file!";
}