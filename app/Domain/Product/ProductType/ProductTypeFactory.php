<?php

namespace App\Domain\Product\ProductType;

class ProductTypeFactory
{

    /**
     * @param  array  $data
     * @return ProductType
     */
    public static function make(array $data): ProductType
    {
        $type = new ProductType();

        return $type
            ->setId($data['id'])
            ->setName($data['name']);
    }


}