<?php

namespace App\Domain\Product;

use App\Domain\Product\ProductType\ProductTypeFactory;
use App\Domain\Product\ProductType\ProductTypeRepo;
use App\Core\App;

class ProductFactory
{

    public static function make(array $data)
    {
        $product = new Product();
        $productTypeData = App::resolve(ProductTypeRepo::class)->getByColumn('slug', $data['product_type']);

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