<?php

namespace App\Product\Infrastructure\Payload;

use App\Shared\Payload;

class UpdateProduct implements Payload
{
    private float $price;
    private string $name;

    /**
     * UpdateProductCommand constructor.
     * @param float $price
     * @param string $name
     */
    public function __construct(float $price, string $name)
    {
        $this->price = $price;
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}