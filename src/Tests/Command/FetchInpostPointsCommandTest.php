<?php

namespace App\Tests\Command;

use App\Api\InpostApiService;
use App\Command\FetchInpostPointsCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class FetchInpostPointsCommandTest extends TestCase
{
    public function testCommandSuccess(): void
    {
        $jsonResponse = json_encode([
            'count' => 2,
            'page' => 1,
            'totalPages' => 1,
            'items' => [
                ['name' => 'KZY01A', 'address' => ['line1' => 'Gajowa 27', 'line2' => 'Kozy']],
                ['name' => 'KZY01M', 'address' => ['line1' => 'Bielska 57', 'line2' => 'Kozy']]
            ]
        ]);

        $apiClient = $this->createMock(InpostApiService::class);
        $apiClient->method('prepare')->willReturn($jsonResponse);

        $commandTester = $this->runCommand($apiClient, ['resource' => 'points', 'city' => 'Kozy']);


        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Dane pobrane pomyślnie!', $output);
    }

    public function testCommandFailure(): void
    {

        $apiClient = $this->createMock(InpostApiService::class);
        $apiClient->method('fetchResource')->willThrowException(new \Exception('Błąd podczas pobierania danych.'));

        $commandTester = $this->runCommand($apiClient, ['resource' => 'points', 'city' => 'Kozy']);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Błąd podczas deserializacji', $output);
    }

    protected function runCommand($apiClient, $queryParams): CommandTester
    {

        $command = new FetchInpostPointsCommand($apiClient);

        $application = new Application();
        $application->add($command);
        $command = $application->find('shipx-api:fetch-inpost-points');
        $commandTester = new CommandTester($command);

        $commandTester->execute($queryParams);

        return $commandTester;
    }
}
