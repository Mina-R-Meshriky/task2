<?php

namespace App\Domain\ProductType;

use App\Core\Database\Repository;

class ProductTypeRepo extends Repository
{

    protected string $table = 'product_types';

}