<?php

namespace App\Product\Infrastructure\Controller;

use App\Product\Application\Command\CreateNewProductCommand;
use App\Product\Application\Command\CreateNewProductCommandHandler;
use App\Product\Application\Command\DeleteProductCommand;
use App\Product\Application\Command\DeleteProductCommandHandler;
use App\Product\Application\Command\UpdateProductCommand;
use App\Product\Application\Command\UpdateProductCommandHandler;
use App\Product\Infrastructure\Query\ProductQuery;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

class ProductApiController
{

    /**
     * @var Serializer
     */
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/products", methods={GET})
     * @param ProductQuery $productFinder
     * @return JsonResponse
     */
    public function getAll(ProductQuery $productFinder)
    {
        $data = $this->serializer->toArray($productFinder->findAll());

        return new JsonResponse($data);
    }

    /**
     * @Route("/products/{uuid}", methods={GET})
     * @param ProductQuery $productFinder
     * @return JsonResponse
     */
    public function get(ProductQuery $productQuery, string $uuid)
    {
        return new JsonResponse($productQuery->find($uuid));
    }

    /**
     * @Route("/products", methods={POST})
     * @param CreateNewProductCommandHandler $handler
     * @param CreateNewProductCommand $command
     */
    public function create(CreateNewProductCommandHandler $handler, CreateNewProductCommand $command)
    {
        $handler->handle($command);
    }

    public function update(UpdateProductCommandHandler $handler, UpdateProductCommand $command)
    {
        $handler->handle($command);
    }

    public function delete(DeleteProductCommandHandler $handler, string $uuid)
    {
        $handler->handle(new DeleteProductCommand($uuid));
    }

}