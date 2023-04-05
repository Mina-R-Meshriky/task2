<?php

namespace App\Core\Validator;

use App\Core\App;
use App\Core\Database\Database;

trait DatabaseRuleTrait
{
    public function getDatabase(): Database
    {
        return App::resolve(Database::class);
    }
}