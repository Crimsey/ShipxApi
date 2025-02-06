<?php
namespace App\Api;

interface ApiClientInterface
{
    public function fetch(string $resource, array $params = []): string;
}