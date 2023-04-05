<?php

namespace App\Core\Exceptions;

use App\Core\Response\Response;
use Exception;

class ExceptionHandler
{
    public static function handle(Exception $exception)
    {
        if ($exception->getCode() != 500) {
            Response::make()
                    ->changeCode($exception->getCode())
                    ->changeContent($exception->getMessage())
                    ->send();
        }


        throw $exception;
    }
}