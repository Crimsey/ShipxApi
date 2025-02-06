<?php
namespace App\Api;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class InpostApiClient implements ApiClientInterface
{
    private string $baseUrl;
    private HttpClientInterface $client;

    public function __construct(
        HttpClientInterface $client,
        string $baseUrl = 'https://api-shipx-pl.easypack24.net/v1'
    ) {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
    }

    public function fetch(string $resource, array $params = []): string
    {
        $queryParams = http_build_query(array_map(fn($value) => ucfirst(strtolower($value)), $params));
        $url = sprintf('%s/%s?%s', $this->baseUrl, $resource, $queryParams);

        try {
            $response = $this->client->request('GET', $url);

            if ($response->getStatusCode() !== 200) {
                throw new \RuntimeException('Błąd podczas pobierania danych: ' . $response->getStatusCode());
            }

            return $response->getContent();
        } catch (TransportExceptionInterface $e) {
            throw new \RuntimeException('Błąd połączenia z API: ' . $e->getMessage());
        }
    }
}
