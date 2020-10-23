<?php

namespace App\Product\Infrastructure\Controller;

use App\Product\Application\Command\CreateNewProductCommand;
use App\Product\Application\Command\CreateNewProductCommandHandler;
use App\Product\Application\Command\DeleteProductCommand;
use App\Product\Application\Command\DeleteProductCommandHandler;
use App\Product\Application\Command\UpdateProductCommand;
use App\Product\Application\Command\UpdateProductCommandHandler;
use App\Product\Infrastructure\Payload\UpdateProduct;
use App\Product\Infrastructure\Query\ProductQuery;
use App\Product\Infrastructure\ReadModel\Product;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use OpenApi\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class ProductApiController
 * @package App\Product\Infrastructure\Controller
 * @Route("/api")
 * @SWG\Tag(name="Products")
 */
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
     * @SWG\Response(
     *     response=200,
     *     description="Product Opinion.",
     *     @Model(type=Product::class)
     * )
     * @Route("/products", methods={"GET"})
     * @param ProductQuery $productFinder
     * @return JsonResponse
     */
    public function getAll(ProductQuery $productFinder)
    {
        $data = $this->serializer->toArray($productFinder->findAll());

        return new JsonResponse($data);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Get product by uuid",
     *     @Model(type=Product::class)
     * )
     *
     * @SWG\Parameter(
     *     required=true,
     *     name="uuid",
     *     @SWG\Schema(type="string"),
     *     in="path",
     *     description="Product Uuid"
     * )
     * @Route("/products/{uuid}", name="get_product", methods={"GET"})
     * @param ProductQuery $productQuery
     * @param string $uuid
     * @return JsonResponse
     */
    public function get(ProductQuery $productQuery, string $uuid)
    {
        $product = $productQuery->find($uuid);

        return new JsonResponse($this->serializer->toArray($product));
    }

    /**
     * @SWG\Response(
     *     response=201,
     *     description="Create Product",
     *     @Model(type=Product::class)
     * )
     *
     * @SWG\Parameter (
     *     name="product",
     *     in="query",
     *     required=true,
     *     @SWG\Schema(type="object", ref=@Model(type=CreateNewProductCommand::class))
     * )
     * @Route("/products", methods={"POST"})
     * @param CreateNewProductCommandHandler $handler
     * @param CreateNewProductCommand $command
     * @param UrlGeneratorInterface $urlGenerator
     * @return JsonResponse
     */
    public function create(CreateNewProductCommandHandler $handler, CreateNewProductCommand $command, UrlGeneratorInterface $urlGenerator)
    {
        $uuid = $handler->handle($command);

        return new JsonResponse('', Response::HTTP_CREATED, [
            'Location' => $urlGenerator->generate('get_product', ['uuid' => $uuid])
        ]);
    }

    /**
     * @SWG\Response(
     *     response=204,
     *     description="Update Product"
     * )
     *
     * @SWG\Parameter (
     *     name="product",
     *     in="query",
     *     required=true,
     *     @SWG\Schema(type="object", ref=@Model(type=UpdateProductCommand::class))
     * )
     * @SWG\Parameter(
     *     required=true,
     *     name="uuid",
     *     @SWG\Schema(type="string"),
     *     in="path",
     *     description="Product Uuid"
     * )
     *
     * @Route("/products/{uuid}", methods={"PUT"})
     * @param UpdateProductCommandHandler $handler
     * @param UpdateProduct $payload
     * @param string $uuid
     * @return JsonResponse
     */
    public function update(UpdateProductCommandHandler $handler, UpdateProduct $payload, string $uuid)
    {
        $command = new UpdateProductCommand(
            $uuid,
            $payload->getPrice(),
            $payload->getName()
        );

        $handler->handle($command);

        return new JsonResponse('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @SWG\Response(
     *     response=204,
     *     description="Delete Product"
     * )
     * @SWG\Parameter(
     *     required=true,
     *     name="uuid",
     *     @SWG\Schema(type="string"),
     *     in="path",
     *     description="Product Uuid"
     * )
     * @Route("/products/{uuid}", methods={"DELETE"})
     * @param DeleteProductCommandHandler $handler
     * @param string $uuid
     */
    public function delete(DeleteProductCommandHandler $handler, string $uuid)
    {
        $handler->handle(new DeleteProductCommand($uuid));

        return new JsonResponse('', Response::HTTP_NO_CONTENT);
    }

}