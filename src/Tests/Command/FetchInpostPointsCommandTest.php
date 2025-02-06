<?php

namespace App\Tests\Command;

use App\Api\InpostApiService;
use App\Command\FetchInpostPointsCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class FetchInpostPointsCommandTest extends TestCase
{
    public function testCommandSuccess(): void
    {
        $jsonResponse = json_encode([
            'count' => 2,
            'page' => 1,
            'totalPages' => 1,
            'items' => [
                ['name' => 'KZY01A', 'address' => ['street' => 'Gajowa 27', 'city' => 'Kozy']],
                ['name' => 'KZY01M', 'address' => ['street' => 'Bielska 57', 'city' => 'Kozy']]
            ]
        ]);

        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $apiClient = $this->createMock(InpostApiService::class);
        $apiClient->method('fetch')->willReturn($jsonResponse);

        $commandTester = $this->runCommand($serializer, $apiClient, ['resource' => 'points', 'city' => 'Kozy']);


        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Dane pobrane pomyślnie!', $output);
    }

    public function testCommandFailure(): void
    {

        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $apiClient = $this->createMock(InpostApiService::class);
        $apiClient->method('fetch')->willThrowException(new \Exception('Błąd podczas pobierania danych.'));

        $commandTester = $this->runCommand($serializer, $apiClient, ['resource' => 'points', 'city' => 'Kozy']);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Błąd podczas deserializacji', $output);
    }

    protected function runCommand($serializer, $apiClient, $queryParams): CommandTester
    {

        $command = new FetchInpostPointsCommand($serializer, $apiClient);

        $application = new Application();
        $application->add($command);
        $command = $application->find('shipx-api:fetch-inpost-points');
        $commandTester = new CommandTester($command);

        $commandTester->execute($queryParams);

        return $commandTester;
    }
}
