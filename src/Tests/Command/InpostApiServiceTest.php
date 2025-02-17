<?php

namespace App\Tests\Command;

use App\Api\ApiClientInterface;
use App\Api\InpostApiService;
use App\Api\Resource\ResourceFactory\ResourceFactory;
use App\Api\Resource\ResourceInterface;
use App\Services\JsonHelper;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class InpostApiServiceTest extends TestCase
{
    private MockObject|ApiClientInterface $apiClient;
    private MockObject|ResourceFactory $resourceFactory;
    private MockObject|ResourceInterface $resource;
    private InpostApiService $apiService;
    private JsonHelper $jsonHelper;

    protected function setUp(): void
    {
        $this->apiClient = $this->createMock(ApiClientInterface::class);
        $this->resourceFactory = $this->createMock(ResourceFactory::class);
        $this->resource = $this->createMock(ResourceInterface::class);

        $serializer = new Serializer([new ObjectNormalizer(), new ArrayDenormalizer()], [new JsonEncoder()]);
        $this->jsonHelper = new JsonHelper($serializer, $this->resourceFactory);

        $this->apiService = new InpostApiService(
            $this->apiClient,
            $this->resourceFactory,
            $this->jsonHelper
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
                ['name' => 'KZY01A', 'address' => ['line1' => 'Gajowa 27', 'line2' => 'Kozy']],
                ['name' => 'KZY01M', 'address' => ['line1' => 'Bielska 57', 'line2' => 'Kozy']]
            ]
        ]);

        // Configure mocks
        $this->resource->method('getEndpoint')->willReturn('points');

        $this->resourceFactory->expects($this->atLeastOnce())
            ->method('createResource')
            ->with('points')
            ->willReturn($this->resource);

        $this->apiClient->expects($this->once())
            ->method('fetch')
            ->with('points', ['city' => 'Kozy'])
            ->willReturn($jsonResponse);

        $response = $this->apiService->prepare('points', ['city' => 'Kozy']);

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

        $this->apiService->prepare('points', ['city' => 'Kozy']);
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
                    'items' => [['name' => 'XYZ01', 'address' => ['line1' => 'Testowa 1', 'line2' => 'TestCity']]],
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
                        ['name' => 'KZY01A', 'address' => ['line1' => 'Gajowa 27', 'line2' => 'Kozy']],
                        ['name' => 'KZY01M', 'address' => ['line1' => 'Bielska 57', 'line2' => 'Kozy']],
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

        $this->resourceFactory->expects($this->atLeastOnce())
            ->method('createResource')
            ->with($resourceName)
            ->willReturn($this->resource);

        $this->apiClient->expects($this->once())
            ->method('fetch')
            ->with($resourceName, $params)
            ->willReturn($jsonResponse);

        $response = $this->apiService->prepare($resourceName, $params);

        self::assertJson($response);
        self::assertEquals($jsonResponse, $response);

        self::assertArrayHasKey('count', json_decode($response, true));
    }
}