<?php
namespace App\Services\Serializer;

use App\Entity\InpostPoint;
use App\Entity\Address;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\PropertyInfo\Type;

/**
 * CustomModelExtractor - Klasa do "podglądania" (i ew. nadpisywania) jak działa serializer
 */
class CustomModelExtractor implements PropertyTypeExtractorInterface
{
    /**
     * @var ReflectionExtractor
     */
    private $reflectionExtractor;

    /**
     * CustomModelExtractor constructor.
     */
    public function __construct()
    {
        $this->reflectionExtractor = new ReflectionExtractor();
    }

    /**
     * @param string $class
     * @param string $property
     * @param array  $context
     *
     * @return array|Type[]|null
     */
    public function getTypes($class, $property, array $context = [])
    {
        return $this->reflectionExtractor->getTypes($class, $property, $context);
    }

}