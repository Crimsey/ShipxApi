<?php
namespace App\Api\Resource;


abstract class AbstractResource implements ResourceInterface
{
    protected string $endpoint;
    protected string $method = 'GET';
    protected array $defaultParams = [];

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getDefaultParams(): array
    {
        return $this->defaultParams;
    }
}