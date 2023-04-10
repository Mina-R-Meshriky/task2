<?php

namespace App\Domain\ProductType;

use App\Domain\Shared\Model;

class ProductType extends Model
{
    private int $id;
    private string $name;

    private string $slug;

    private string $require;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param  int  $id
     * @return ProductType
     */
    public function setId(int $id): ProductType
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
     * @return ProductType
     */
    public function setName(string $name): ProductType
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param  string  $slug
     * @return ProductType
     */
    public function setSlug(string $slug): ProductType
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getRequire(): string
    {
        return $this->require;
    }

    /**
     * @param  string  $require
     * @return ProductType
     */
    public function setRequire(string $require): ProductType
    {
        $this->require = $require;
        return $this;
    }

    function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'require' => $this->require
        ];
    }
}