<?php

namespace App\Product\Domain;

use App\Shared\Uuid;

interface ProductRepository
{

    public function findOne(string $uuid): ?Product;

    /**
     * @return Product[]
     */
    public function findAll(): array;

    public function save(Product $product);

    public function delete(Product $product);
}