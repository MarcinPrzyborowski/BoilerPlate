<?php

namespace App\Product\Application\Command;

use App\Product\Domain\ProductRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteProductCommandHandler
{
    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function handle(DeleteProductCommand $command)
    {
        $product = $this->productRepository->findOne($command->getUuid());

        if ($product === null) {
            throw new NotFoundHttpException();
        }

        $this->productRepository->delete($product);
    }
}