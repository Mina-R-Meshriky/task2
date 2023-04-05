<?php

namespace App\Domain\Product;


class ProductService
{

    private ProductRepo $productRepo;

    public function __construct(ProductRepo $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    /**
     * @return array<Product>
     */
    public function getAllProducts(): array
    {
        $productsArray = $this->productRepo->all();

        foreach ($productsArray as $product) {
            $products[] = ProductFactory::make($product);
        }

        return $products ?? [];
    }

    public function getById($id): ?Product
    {
        if ($data = $this->productRepo->get($id)) {
            return ProductFactory::make($data);
        }

        return null;
    }

    public function create(ProductDTO $productDTO): Product
    {
        $id = $this->productRepo->create($productDTO->toArray());

        if ($id) {
            $productDTO->id = $id;
        }

        return ProductFactory::make($productDTO->toArray());
    }

    public function delete($id): bool
    {
        return $this->productRepo->delete($id);
    }

    public function bulkDelete($ids): int
    {
        $ids = array_map(static fn($i) => trim($i), explode(',', $ids));
        return $this->productRepo->bulkDelete($ids);
    }

}