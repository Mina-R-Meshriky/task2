<?php

namespace App\Domain\ProductType;

class ProductTypeService
{
    private ProductTypeRepo $repo;

    public function __construct(ProductTypeRepo $repo)
    {
        $this->repo = $repo;
    }


    public function all(): array
    {
        $productTypesArray = $this->repo->all();

        foreach ($productTypesArray as $productType) {
            $productTypes[] = ProductTypeFactory::make($productType);
        }

        return $productTypes ?? [];
    }
}