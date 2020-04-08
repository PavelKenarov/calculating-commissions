<?php
namespace App\Controllers;

use App\Exceptions;

class Context
{
    public $parser;

    /**
     * @param parser $parser
     */
    public function __construct(parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param parser $parser
     */
    public function setParser(parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param $file string
     */
    public function calculateCommissions($file)
    {
        return $this->parser->doCalculations($file);
    }

    /**
     * @param $file string
     * @throws Exceptions\FileMissedException
     */
    public function start($file)
    {
        if (empty($file) || !is_file($file) || !fopen($file,'r'))
        {
            throw new Exceptions\FileMissedException("Not found transaction file!");
        }

        return $this->calculateCommissions($file);
    }

}