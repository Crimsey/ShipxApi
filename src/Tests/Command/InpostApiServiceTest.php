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

        $response = $this->apiService->fetch('points', ['city' => 'Kozy']);

        self::assertEquals($jsonResponse, $response);
    }

    public function testFetchFailure(): void
    {
        $this->resource->method('getEndpoint')->willReturn('points');

        $this->resourceFactory->expects($this->once())
            ->method('createResource')
            ->with('points')
            ->willReturn($this->resource);

        $this->apiClient->expects($this->once())
            ->method('fetch')
            ->willThrowException(new \RuntimeException('Błąd podczas pobierania danych'));

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Błąd podczas pobierania danych');

        $this->apiService->fetch('points', ['city' => 'Kozy']);
    }

    public function fetchDataProvider(): array
    {
        return [
            'empty response' => [
                json_encode(['count' => 0, 'page' => 1, 'totalPages' => 1, 'items' => []]),
                'points',
                ['city' => 'A'],
            ],
            'single point' => [
                json_encode([
                    'count' => 1,
                    'page' => 1,
                    'totalPages' => 1,
                    'items' => [['name' => 'XYZ01', 'address' => ['street' => 'Testowa 1', 'city' => 'TestCity']]],
                ]),
                'points',
                ['city' => 'TestCity'],
            ],
            'multiple points' => [
                json_encode([
                    'count' => 2,
                    'page' => 1,
                    'totalPages' => 1,
                    'items' => [
                        ['name' => 'KZY01A', 'address' => ['street' => 'Gajowa 27', 'city' => 'Kozy']],
                        ['name' => 'KZY01M', 'address' => ['street' => 'Bielska 57', 'city' => 'Kozy']],
                    ],
                ]),
                'points',
                ['city' => 'Kozy'],
            ],
        ];
    }

    /**
     * @dataProvider fetchDataProvider
     */
    public function testFetchWithDataProvider(string $jsonResponse, string $resourceName, array $params): void
    {
        $this->resource->method('getEndpoint')->willReturn($resourceName);

        $this->resourceFactory->expects($this->once())
            ->method('createResource')
            ->with($resourceName)
            ->willReturn($this->resource);

        $this->apiClient->expects($this->once())
            ->method('fetch')
            ->with($resourceName, $params)
            ->willReturn($jsonResponse);

        $response = $this->apiService->fetch($resourceName, $params);

        self::assertJson($response);
        self::assertEquals($jsonResponse, $response);

        self::assertArrayHasKey('count', json_decode($response, true));
    }
}