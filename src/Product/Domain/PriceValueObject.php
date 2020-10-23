<?php

namespace App\Product\Domain;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class PriceValueObject
{
    /**
     * @ORM\Column(type="float")
     */
    private float $price;

    /**
     * PriceValueObject constructor.
     * @param float $price
     */
    public function __construct(float $price)
    {
        if ($price < 0) {
            throw new \InvalidArgumentException(sprintf('Price (%s) cannot be a negative number', $price));
        }

        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->price;
    }

}