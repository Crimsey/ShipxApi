<?php

namespace App\Services;

use App\Api\Resource\ResourceFactory\ResourceFactory;
use App\Entity\ApiResponse;
use App\Entity\InpostPoint;
use App\Entity\Address;
use App\Entity\PointResponse;
use Symfony\Component\Serializer\SerializerInterface;

class JsonHelper
{
    private SerializerInterface $serializer;
    private ResourceFactory $resourceFactory;

    public function __construct(SerializerInterface $serializer, ResourceFactory $resourceFactory)
    {
        $this->serializer = $serializer;
        $this->resourceFactory = $resourceFactory;
    }

    protected function getTypes(string $resource): array
    {
        try {
            $resource = $this->resourceFactory->createResource($resource);
        } catch (\Exception $e) {
            throw new \Exception('Nie znaleziono zasobu: ' . $e->getMessage());
        }

        switch ($resource->getEndpoint()) {
            case 'points':
                return [
                    'area' => PointResponse::class,
                    'main' => InpostPoint::class,
                    'nested' => Address::class,
                ];
            default:
                return [];
        }

    }

    /**
     * @throws \Exception
     */
    public function deserializeResource(string $resource, string $jsonContent): ApiResponse
    {
        $types = $this->getTypes($resource);

        if (!empty($types) && isset($types['main'], $types['nested'], $types['area'])) {
            $area = $this->serializer->deserialize($jsonContent, $types['area'], 'json');

            if (!empty($area)) {
                $points = $this->serializer->deserialize(
                    json_encode($area->getItems()),
                    $types['main'] . '[]', //zagnieżdżone
                    'json'
                );


                $area->setItems($points);

                return $area;
            }
        }

        throw new \Exception("Deserializacja nie powiodła się.");
    }
}
