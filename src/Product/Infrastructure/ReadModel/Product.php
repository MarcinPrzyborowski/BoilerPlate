<?php

namespace App\Product\Infrastructure\ReadModel;

use App\Shared\Uuid;

class Product
{
    private Uuid $uuid;
    private string $name;
    private float $price;

    /**
     * Product constructor.
     * @param string $name
     * @param float $price
     */
    public function __construct(Uuid $uuid, string $name, float $price)
    {
        $this->name = $name;
        $this->price = $price;
        $this->uuid = $uuid;
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}