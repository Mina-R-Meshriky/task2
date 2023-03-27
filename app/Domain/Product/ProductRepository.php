<?php

namespace App\Domain\Product;



use App\Helpers\Database\Repository;

class ProductRepository extends Repository
{

    protected string $table = 'products';

}