<?php

namespace App\Exceptions;

class GetBinException extends \Exception
{
    public function __construct($message, $code = 0, Exception $previous = null) {
        //Additional logic to notify the administrator
        parent::__construct($message, $code, $previous);
    }
}
