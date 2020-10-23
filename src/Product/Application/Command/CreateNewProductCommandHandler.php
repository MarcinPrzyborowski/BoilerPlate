<?php

namespace App\Product\Application\Command;

use App\Product\Domain\PriceValueObject;
use App\Product\Domain\Product;
use App\Product\Domain\ProductRepository;
use App\Shared\Uuid;

class CreateNewProductCommandHandler
{

    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function handle(CreateNewProductCommand $command)
    {
        $product = new Product(
            Uuid::random(),
            new PriceValueObject($command->getPrice()),
            $command->getName()
        );

        $this->productRepository->save($product);

        return $product->getUuid();
    }

}