<?php

namespace App\Domain\Product;

class ProductService
{

    private ProductRepository $productRepo;

    public function __construct(ProductRepository $productRepo) {
        $this->productRepo = $productRepo;
    }

    /**
     * @return array<Product>
     */
    public function getAllProducts(): ?array
    {
        $productsArray = $this->productRepo->all();

        foreach($productsArray as $product) {
            $products[] = ProductFactory::make($product)->toArray();
        }

        return $products ?? null;
    }

}