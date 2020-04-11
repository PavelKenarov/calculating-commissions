<?php
namespace App\Controllers;

use App\AppConfig;
use App\Exceptions;

class Context
{
    public $parser;

    /**
     * @param $parser
     */
    public function __construct($parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param $parser
     */
    public function setParser($parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param $file string
     * @return float
     */
    public function calculateCommissions($file)
    {
        return $this->parser->doCalculations($file);
    }

    /**
     * @param $file string
     * @return string
     * @throws Exceptions\FileMissedException
     */
    public function start($file)
    {
        if (empty($file) || !is_file($file) || !fopen($file,'r'))
        {
            throw new Exceptions\FileMissedException(AppConfig::$MISSING_FILE);
        }

        return $this->calculateCommissions($file);
    }

}