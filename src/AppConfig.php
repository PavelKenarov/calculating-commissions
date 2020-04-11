<?php
namespace App;

class AppConfig
{
    // class FileParser
    public static $EU_TAX          = 0.01;
    public static $TAX             = 0.02;
    public static $NO_FILE         = "Invalid file row ";
    public static $CURRENCY_PR     = "Invalid currency on row ";
    public static $CURRENCY_REGEXP = '/^[A-Z]{3}$/';
    public static $DECIMALS        = 2; // number_format parameter at final result - set the number of decimal points.

    // class IsFromEu
    public static $BIN_URL         = 'https://lookup.binlist.net/';
    public static $EU_COUNTRIES    = array('AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'EL', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK');
    public static $BIN_EXCEPTION   = "Not find country code from bin number on row ";

    // class GetExchangeRates
    public static $NO_COMMISSION   = 'EUR'; // Has no commission added for this currency
    public static $RATE_URL        = 'https://api.exchangeratesapi.io/latest/';
    public static $RATE_EXCEPTION  = "Not find rate on row ";

    // class FileMissedException
    public static $MISSING_FILE    = "Not found transaction file!";
}