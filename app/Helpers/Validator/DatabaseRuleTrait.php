<?php

namespace App\Helpers\Validator;

use App\Helpers\App;
use App\Helpers\Database\Database;

trait DatabaseRuleTrait
{
    public function getDatabase(): Database
    {
        return App::resolve(Database::class);
    }
}