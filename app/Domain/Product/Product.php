<?php

namespace App\Domain\Product;

use App\Domain\Product\ProductType\ProductType;

class Product
{
    private int $id;
    private string $name;
    private string $sku;
    private int $price;
    private ProductType $productType;
    private ?int $size;
    private ?int $weight;
    private ?int $height;
    private ?int $length;
    private ?int $width;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param  int  $id
     * @return Product
     */
    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param  string  $name
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @param  string  $sku
     * @return Product
     */
    public function setSku(string $sku): Product
    {
        $this->sku = $sku;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param  int  $price
     * @return Product
     */
    public function setPrice(int $price): Product
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return ProductType
     */
    public function getProductType(): ProductType
    {
        return $this->productType;
    }

    /**
     * @param  ProductType  $productType
     * @return Product
     */
    public function setProductType(ProductType $productType): Product
    {
        $this->productType = $productType;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * @param  int|null  $size
     * @return Product
     */
    public function setSize(?int $size): Product
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getWeight(): ?int
    {
        return $this->weight;
    }

    /**
     * @param  int|null  $weight
     * @return Product
     */
    public function setWeight(?int $weight): Product
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @param  int|null  $height
     * @return Product
     */
    public function setHeight(?int $height): Product
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLength(): ?int
    {
        return $this->length;
    }

    /**
     * @param  int|null  $length
     * @return Product
     */
    public function setLength(?int $length): Product
    {
        $this->length = $length;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * @param  int|null  $width
     * @return Product
     */
    public function setWidth(?int $width): Product
    {
        $this->width = $width;
        return $this;
    }


    public function toArray(): array
    {
        return [
          'id' => $this->id,
          'name' => $this->name,
          'sku' => $this->sku,
          'price' => $this->price,
          'productType' => $this->productType->toArray(),
          'size' => $this->size,
          'weight' => $this->weight,
          'Dimensions' => "$this->height x $this->width x $this->length"
        ];
    }

}