<?php

namespace App\Product\Infrastructure\Repository;

use App\Product\Domain\Product;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class ProductRepository extends ServiceEntityRepository implements \App\Product\Domain\ProductRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findOne($id): ?Product
    {
        return $this->find($id);
    }

    /**
     * @return Product[]
     */
    public function findAll(): array
    {
        return parent::findAll();
    }

    public function save(Product $product)
    {
       $em = $this->getEntityManager();

       $em->persist($product);
       $em->flush();
    }

    public function delete(Product $product)
    {
        $em = $this->getEntityManager();
        $em->remove($product);
        $em->flush();
    }
}