<?php

namespace App\Helpers\Exceptions;

use Exception;

class ValidationException extends Exception
{

    public function __construct($message = [], $code = 422, Exception $previous = null)
    {
        $msg = [
            'code' => $code,
            'errors' => $message
        ];

        parent::__construct(json_encode($msg), $code, $previous);
    }

}