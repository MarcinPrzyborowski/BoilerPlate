<?php

namespace App\Product\Application\Command;

use App\Product\Domain\PriceValueObject;
use App\Product\Domain\ProductRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateProductCommandHandler
{

    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function handle(UpdateProductCommand $command)
    {
        $product = $this->productRepository->findOne($command->getUuid());

        if ($product === null) {
            throw new NotFoundHttpException();
        }

        $product->changeName($command->getName());
        $product->changePrice(new PriceValueObject($command->getPrice()));

        $this->productRepository->save($product);
    }

}