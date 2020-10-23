<?php

namespace App\Product\Domain;

use App\Shared\Uuid;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="guid")
     */
    private string $uuid;
    /**
     * @ORM\Embedded(class="App\Product\Domain\PriceValueObject")
     */
    private PriceValueObject $price;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * Product constructor.
     * @param Uuid $uuid
     * @param PriceValueObject $price
     * @param string $name
     */
    public function __construct(Uuid $uuid, PriceValueObject $price, string $name)
    {
        $this->uuid = $uuid;
        $this->price = $price;
        $this->name = $name;
    }

    /**
     * @param PriceValueObject $price
     */
    public function changePrice(PriceValueObject $price): void
    {
        $this->price = $price;
    }

    /**
     * @param string $name
     */
    public function changeName(string $name): void
    {
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
     * @return PriceValueObject
     */
    public function getPrice(): PriceValueObject
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