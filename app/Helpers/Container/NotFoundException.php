<?php

namespace App\Helpers\Container;

use Psr\Container\NotFoundExceptionInterface;
use Exception;

class NotFoundException extends Exception implements NotFoundExceptionInterface
{

}