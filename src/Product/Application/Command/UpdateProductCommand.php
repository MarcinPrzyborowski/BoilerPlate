<?php

namespace App\Product\Application\Command;

use App\Shared\Payload;
use App\Shared\Uuid;

class UpdateProductCommand implements Payload
{
    private Uuid $uuid;
    private float $price;
    private string $name;

    /**
     * UpdateProductCommand constructor.
     * @param Uuid $uuid
     * @param float $price
     * @param string $name
     */
    public function __construct(Uuid $uuid, float $price, string $name)
    {
        $this->uuid = $uuid;
        $this->price = $price;
        $this->name = $name;
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
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