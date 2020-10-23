<?php

namespace App\Request;

use App\Shared\Payload;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestParamConverter implements ParamConverterInterface
{
    /** @var ValidatorInterface */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Stores the object in the request.
     *
     * @param Request $request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @return bool True if the object has been successfully set, else false
     * @throws \ReflectionException
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $queryParameters = $request->query->all();
        $requestParameters = $request->request->all();
        $routeParameters = $request->attributes->get('_route_params');

        $contentParameters = [];

        $requestContent = $request->getContent();
        if(is_string($requestContent) && json_decode($requestContent) !== null) {

            $contentParameters = json_decode($requestContent, true);
        }
        $parameters = $queryParameters + $routeParameters + $requestParameters + $contentParameters;
        $parameters = $this->filterParameters($parameters);

        $serializerBuilder = \JMS\Serializer\SerializerBuilder::create();
        $serializer = $serializerBuilder->build();

        $object = $serializer->deserialize(json_encode($parameters), $configuration->getClass(), 'json');
        foreach ($request->files->all() as $filedName => $file) {
            if (property_exists($object, $filedName)) {
                $reflectionClass = new \ReflectionClass($configuration->getClass());
                $reflectionProperty = $reflectionClass->getProperty($filedName);
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($object, $file);
            }
        }
        $this->validate($object);
        $request->attributes->set($configuration->getName(), $object);
        return true;
    }

    /**
     * Checks if the object is supported.
     *
     * @param ParamConverter $configuration
     * @return bool True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration)
    {
        return is_subclass_of($configuration->getClass(), Payload::class);
    }

    /**
     * @param $object
     */
    private function validate($object): void
    {
        $errors = $this->validator->validate($object);
        if (count($errors) > 0) {
            throw new InvalidPayloadException($errors);
        };
    }

    private function filterParameters(array $parameters)
    {

        $filtered = [];
        foreach ($parameters as $key => $parameter) {

            if (is_string($parameter) && trim($parameter) === '') {

                continue;
            }

            if (is_array($parameter)) {

                $parameter = $this->filterParameters($parameter);
            }

            $filtered[$key] = $parameter;
        }

        return $filtered;

    }
}