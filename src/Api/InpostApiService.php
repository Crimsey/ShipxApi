<?php
namespace App\Api;
use App\Api\Resource\ResourceFactory\ResourceFactory;
use App\Services\JsonHelper;

class InpostApiService
{
    private ApiClientInterface $client;
    private ResourceFactory $resourceFactory;

    private JsonHelper $jsonHelper;


    public function __construct(ApiClientInterface $client, ResourceFactory $resourceFactory, JsonHelper $jsonHelper)
    {
        $this->client = $client;
        $this->resourceFactory = $resourceFactory;
        $this->jsonHelper = $jsonHelper;
    }

    /**
     * @throws \Exception
     */
    public function fetchResource(string $resource, array $params = []): \App\Entity\ApiResponse
    {
        return $this->handle($resource, $this->prepare($resource,$params));
    }

    /**
     * @throws \Exception
     */
    public function prepare(string $resource, array $params = []): string
    {
        $resource = $this->resourceFactory->createResource($resource);
        $mergedParams = array_merge($resource->getDefaultParams(), $params);
        return $this->client->fetch($resource->getEndpoint(), $mergedParams);
    }

    /**
     * @throws \Exception
     */
    public function handle(string $resource, string $result): \App\Entity\ApiResponse
    {
        return $this->jsonHelper->deserializeResource($resource, $result);
    }
}