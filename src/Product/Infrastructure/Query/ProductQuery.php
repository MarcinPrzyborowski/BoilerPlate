<?php

namespace App\Product\Infrastructure\Query;

use App\Product\Domain\ProductRepository;
use App\Product\Infrastructure\ReadModel\Product;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductQuery
{

    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function find(string $uuid): ?Product
    {
        $productEntity = $this->productRepository->findOne($uuid);

        if ($productEntity === null) {
            throw new NotFoundHttpException();
        }

        return new Product(
            $productEntity->getUuid(),
            $productEntity->getName(),
            $productEntity->getPrice()->getValue()
        );
    }

    /**
     * @return Product[]
     */
    public function findAll(): array
    {
        $productEntityCollection = $this->productRepository->findAll();

        $products = [];
        foreach ($productEntityCollection as $product) {
            $products[] = new Product(
                $product->getUuid(),
                $product->getName(),
                $product->getPrice()->getValue()
            );
        }

        return $products;
    }

}