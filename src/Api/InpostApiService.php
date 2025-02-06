<?php
namespace App\Api;
use App\Api\Resource\ResourceFactory\ResourceFactory;

class InpostApiService
{
    private ApiClientInterface $client;
    private ResourceFactory $resourceFactory;

    public function __construct(ApiClientInterface $client, ResourceFactory $resourceFactory)
    {
        $this->client = $client;
        $this->resourceFactory = $resourceFactory;
    }

    public function fetch(string $resource, array $params = []): string
    {
        $resource = $this->resourceFactory->createResource($resource);
        $mergedParams = array_merge($resource->getDefaultParams(), $params);
        return $this->client->fetch($resource->getEndpoint(), $mergedParams);
    }
}