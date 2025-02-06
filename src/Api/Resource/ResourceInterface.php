<?php
namespace App\Api\Resource;

interface ResourceInterface
{
    public function getEndpoint(): string;
    public function getMethod(): string;
    public function getDefaultParams(): array;
}