<?php

namespace App\Entity;

class Address
{
    private string $line1;

    private string $line2;

    public function __construct(string $line1 = '', string $line2 = '')
    {
        $this->line1 = $line1;
        $this->line2 = $line2;
    }

    public function getLine1(): string
    {
        return $this->line1;
    }

    public function setLine1(string $line1): void
    {
        $this->line1 = $line1;
    }

    public function getLine2(): string
    {
        return $this->line2;
    }

    public function setLine2(string $line2): void
    {
        $this->line2 = $line2;
    }
}

