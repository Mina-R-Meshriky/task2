<?php

namespace App\Domain\Product;

use App\Domain\ProductType\ProductTypeFactory;

class ProductFactory
{

    public static function make(array $data, array $productTypeData = [])
    {
        $product = new Product();

        return $product
            ->setId($data['id'])
            ->setName($data['name'])
            ->setSku($data['sku'])
            ->setPrice($data['price'])
            ->setProductType(ProductTypeFactory::make($productTypeData))
            ->setSize($data['size'])
            ->setWeight($data['weight'])
            ->setLength($data['length'])
            ->setWidth($data['width'])
            ->setHeight($data['height']);
    }

}