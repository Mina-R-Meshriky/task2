<?php

namespace App\Helpers\Exceptions;

use Exception;

class BadRequestException extends Exception
{

    public function __construct($message = "", $code = 400, Exception $previous = null)
    {
        parent::__construct(json_encode([
            'error' => $code,
            'msg' => $message
        ]), $code, $previous);
    }

}