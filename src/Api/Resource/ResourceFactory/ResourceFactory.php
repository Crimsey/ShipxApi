<?php
namespace App\Api\Resource\ResourceFactory;

use App\Api\Resource\PointsResource;
use App\Api\Resource\ResourceInterface;
use InvalidArgumentException;

class ResourceFactory
{
    private const RESOURCES = [
        'points' => PointsResource::class,
    ];

    public function createResource(string $resourceName): ResourceInterface
    {
        if (!isset(self::RESOURCES[$resourceName])) {
            throw new InvalidArgumentException(sprintf('Unknown resource type: %s', $resourceName));
        }

        $resourceClass = self::RESOURCES[$resourceName];
        return new $resourceClass();
    }
}