<?php

namespace App\Domain\Product;


use App\Core\Validator\Integer;
use App\Core\Validator\Numeric;
use App\Core\Validator\Letters;
use App\Core\Validator\Max;
use App\Core\Validator\In;
use App\Core\Validator\Required;
use App\Core\Validator\OnlyIf;
use App\Core\Validator\Unique;
use App\Core\Validator\Validator;

class ProductDTO
{
    public ?int $id;
    public ?string $name;
    public ?string $sku;
    public ?string $price;
    public ?string $productType;
    public ?string $size;
    public ?string $weight;
    public ?string $height;
    public ?string $length;
    public ?string $width;
    private ?string $productTypeRequire;

    public function __construct(
        ?string $id,
        ?string $name,
        ?string $sku,
        ?string $price,
        ?string $productType,
        ?string $size,
        ?string $weight,
        ?string $height,
        ?string $length,
        ?string $width,
        ?string $productTypeRequire
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->sku = $sku;
        $this->price = $price;
        $this->productType = $productType;
        $this->size = $size;
        $this->weight = $weight;
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
        $this->productTypeRequire = $productTypeRequire;

        $this->validate();
    }

    public static function fromRequest(array $data): self
    {
        return new self (
            $data['id'] ?: null,
            $data['name'] ?: null,
            $data['sku'] ?: null,
            $data['price'] ?: null,
            $data['productType'] ?: null,
            $data['size'] ?: null,
            $data['weight'] ?: null,
            $data['height'] ?: null,
            $data['length'] ?: null,
            $data['width'] ?: null,
            $data['productTypeRequire'] ?: null,
        );
    }


    public function toArray(): array
    {
        $all = get_object_vars($this);
        $all['product_type'] = $all['productType'];
        unset($all['productTypeRequire'], $all['productType']);

        return $all;
    }

    /**
     * @throws \Exception
     */
    public function validate(): array
    {
        return Validator::make(get_object_vars($this), [
            'name' => [new Required, new Letters, new Max(45)],
            'sku' => [new Required, new Letters, new Max(45), new Unique('products', 'sku')],
            'price' => [new Required, new Numeric],
            'productType' => [new Required, new Integer],
            'productTypeRequire' => [new Required, new In('size', 'weight', 'dimensions')],
            'size' => [new OnlyIf($this->productTypeRequire == 'size'), new Required, new Numeric],
            'weight' => [new OnlyIf($this->productTypeRequire == 'weight'), new Required, new Numeric],
            'length' => [new OnlyIf($this->productTypeRequire == 'dimensions'), new Required, new Numeric],
            'width' => [new OnlyIf($this->productTypeRequire == 'dimensions'), new Required, new Numeric],
            'height' => [new OnlyIf($this->productTypeRequire == 'dimensions'), new Required, new Numeric],

        ])->validate();
    }
}