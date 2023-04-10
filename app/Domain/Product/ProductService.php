<?php

namespace App\Domain\Product;


use App\Domain\ProductType\ProductTypeRepo;

class ProductService
{

    private ProductRepo $productRepo;
    private ProductTypeRepo $productTypeRepo;

    public function __construct(ProductRepo $productRepo, ProductTypeRepo $productTypeRepo)
    {
        $this->productRepo = $productRepo;
        $this->productTypeRepo = $productTypeRepo;

    }

    /**
     * @return array<Product>
     */
    public function getAllProducts($filters): array
    {
        $productsArray = $this->productRepo->all($filters);

        // to solve the N+1 problem.
        foreach ($productsArray as $product) {
            if (isset($productTypes[$product['product_type']])) {
                continue;
            }
            $productTypes[$product['product_type']] = true;
        }

        $productTypesData = $this->productTypeRepo->getManyByColumn('id', array_keys($productTypes ?? []));

        foreach ($productsArray as $product) {
            $productTypeData = array_filter($productTypesData, fn($i) => $i['id'] == $product['product_type']);
            $products[] = ProductFactory::make($product, reset($productTypeData));
        }

        return $products ?? [];
    }

    public function getById($id): ?Product
    {
        if ($data = $this->productRepo->get($id)) {

            $productTypeData = $this->productTypeRepo->get($data['product_type']);

            return ProductFactory::make($data, $productTypeData);
        }

        return null;
    }

    public function create(ProductDTO $productDTO): Product
    {
        $id = $this->productRepo->create($productDTO->toArray());

        if ($id) {
            $productDTO->id = $id;
        }

        $productTypeData = $this->productTypeRepo->get($productDTO->productType);

        return ProductFactory::make($productDTO->toArray(), $productTypeData);
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