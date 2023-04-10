<?php

namespace App\Domain\Product;

use App\Domain\ProductType\ProductType;
use App\Domain\Shared\Model;
use App\Domain\Shared\VO\Dimension;
use App\Domain\Shared\VO\Money;
use App\Domain\Shared\VO\Size;
use App\Domain\Shared\VO\Weight;

class Product extends Model
{
    private int $id;
    private string $name;
    private string $sku;
    private string $price;
    private ProductType $productType;
    private ?string $size;
    private ?string $weight;
    private ?string $height;
    private ?string $length;
    private ?string $width;

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
     * @return Money
     */
    public function getPrice(): Money
    {
        return Money::from($this->price);
    }

    /**
     * @param  string  $price
     * @return Product
     */
    public function setPrice(string $price): Product
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
     * @return Size|null
     */
    public function getSize(): ?Size
    {
        return Size::from($this->size);
    }

    /**
     * @param  string|null  $size
     * @return Product
     */
    public function setSize(?string $size): Product
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return Weight|null
     */
    public function getWeight(): ?Weight
    {
        return Weight::from($this->weight);
    }

    /**
     * @param  string|null  $weight
     * @return Product
     */
    public function setWeight(?string $weight): Product
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return Dimension|null
     */
    public function getHeight(): ?Dimension
    {
        return Dimension::from($this->height);
    }

    /**
     * @param  string|null  $height
     * @return Product
     */
    public function setHeight(?string $height): Product
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return Dimension|null
     */
    public function getLength(): ?Dimension
    {
        return Dimension::from($this->length);
    }

    /**
     * @param  string|null  $length
     * @return Product
     */
    public function setLength(?string $length): Product
    {
        $this->length = $length;
        return $this;
    }

    /**
     * @return Dimension|null
     */
    public function getWidth(): ?Dimension
    {
        return Dimension::from($this->width);
    }

    /**
     * @param  string|null  $width
     * @return Product
     */
    public function setWidth(?string $width): Product
    {
        $this->width = $width;
        return $this;
    }

    function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'price' => $this->getPrice()->formatted,
            'productType' => $this->productType,
            'size' => str_contains($this->productType->getRequire(), 'size') ? $this->getSize()->formatted : null,
            'weight' => str_contains($this->productType->getRequire(), 'weight') ? $this->getWeight()->formatted : null,
            'dimensions' => str_contains($this->productType->getRequire(), 'dimensions')
                ? $this->getHeight()->formatted." x ".$this->getWidth()->formatted ." x ". $this->getLength()->formatted
                : null,
        ];
    }
}