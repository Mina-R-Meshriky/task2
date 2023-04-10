<?php

namespace App\Domain\ProductType;

class ProductTypeFactory
{

    /**
     * @param  ?array  $data
     * @return ProductType
     */
    public static function make(?array $data): ?ProductType
    {
        if (is_null($data)) {
            return null;
        }

        return (new ProductType())
            ->setId($data['id'])
            ->setName($data['name'])
            ->setSlug($data['slug'])
            ->setRequire($data['required']);
    }


}