<?php

namespace App\Product\Application\Command;

use App\Shared\Uuid;

class UpdateProductCommand
{
    private string $uuid;
    private float $price;
    private string $name;

    /**
     * UpdateProductCommand constructor.
     * @param string $uuid
     * @param float $price
     * @param string $name
     */
    public function __construct(string $uuid, float $price, string $name)
    {
        $this->uuid = $uuid;
        $this->price = $price;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
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