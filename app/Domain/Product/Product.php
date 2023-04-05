<?php

namespace App\Domain\Product;

use App\Domain\Product\ProductType\ProductType;
use App\Domain\Shared\Model;
use App\Domain\Shared\VO\Dimension;
use App\Domain\Shared\VO\Size;
use App\Domain\Shared\VO\Weight;

class Product extends Model
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
     * @return Size|null
     */
    public function getSize(): ?Size
    {
        return Size::from($this->size);
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
     * @return Weight|null
     */
    public function getWeight(): ?Weight
    {
        return Weight::from($this->weight);
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
     * @return Dimension|null
     */
    public function getHeight(): ?Dimension
    {
        return Dimension::from($this->height);
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
     * @return Dimension|null
     */
    public function getLength(): ?Dimension
    {
        return Dimension::from($this->length);
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
     * @return Dimension|null
     */
    public function getWidth(): ?Dimension
    {
        return Dimension::from($this->width);
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

    function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'price' => $this->price,
            'productType' => $this->productType,
            'size' => str_contains($this->productType->getRequire(), 'size') ? $this->getSize()->formatted : null,
            'weight' => str_contains($this->productType->getRequire(), 'weight') ? $this->getWeight()->formatted : null,
            'dimensions' => str_contains($this->productType->getRequire(), 'dimensions')
                ? $this->getHeight()->formatted." x ".$this->getWidth()->formatted ." x ". $this->getLength()->formatted
                : null,
        ];
    }
}