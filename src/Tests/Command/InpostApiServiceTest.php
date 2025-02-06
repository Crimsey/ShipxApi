<?php

namespace App\Tests\Command;

use App\Api\ApiClientInterface;
use App\Api\InpostApiService;
use App\Api\Resource\ResourceFactory\ResourceFactory;
use App\Api\Resource\ResourceInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class InpostApiServiceTest extends TestCase
{
    private MockObject|ApiClientInterface $apiClient;
    private MockObject|ResourceFactory $resourceFactory;
    private MockObject|ResourceInterface $resource;
    private InpostApiService $apiService;

    protected function setUp(): void
    {
        $this->apiClient = $this->createMock(ApiClientInterface::class);
        $this->resourceFactory = $this->createMock(ResourceFactory::class);
        $this->resource = $this->createMock(ResourceInterface::class);

        $this->apiService = new InpostApiService(
            $this->apiClient,
            $this->resourceFactory
        );
    }

    public function testFetchSuccess(): void
    {
        // Prepare test data
        $jsonResponse = json_encode([
            'count' => 2,
            'page' => 1,
            'totalPages' => 1,
            'items' => [
                ['name' => 'KZY01A', 'address' => ['street' => 'Gajowa 27', 'city' => 'Kozy']],
                ['name' => 'KZY01M', 'address' => ['street' => 'Bielska 57', 'city' => 'Kozy']]
            ]
        ]);

        // Configure mocks
        $this->resource->method('getEndpoint')->willReturn('points');

        $this->resourceFactory->expects($this->once())
            ->method('createResource')
            ->with('points')
            ->willReturn($this->resource);

        $this->apiClient->expects($this->once())
            ->method('fetch')
            ->with('points', ['city' => 'Kozy'])
            ->willReturn($jsonResponse);

        // Execute test
        $response = $this->apiService->fetch('points', ['city' => 'Kozy']);

        // Assert
        self::assertEquals($jsonResponse, $response);
    }

    public function testFetchFailure(): void
    {
        // Configure mocks
        $this->resource->method('getEndpoint')->willReturn('points');

        $this->resourceFactory->expects($this->once())
            ->method('createResource')
            ->with('points')
            ->willReturn($this->resource);

        $this->apiClient->expects($this->once())
            ->method('fetch')
            ->willThrowException(new \RuntimeException('Błąd podczas pobierania danych'));

        // Assert exception
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Błąd podczas pobierania danych');

        // Execute test
        $this->apiService->fetch('points', ['city' => 'Kozy']);
    }
}