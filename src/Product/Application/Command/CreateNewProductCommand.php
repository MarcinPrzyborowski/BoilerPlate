<?php

namespace App\Product\Application\Command;


use App\Shared\Payload;

class CreateNewProductCommand implements Payload
{

    private float $price;
    private string $name;

    /**
     * CreateNewProductCommand constructor.
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