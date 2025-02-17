<?php

namespace App\Entity;

class PointResponse extends ApiResponse
{

    /** @var InpostPoint[] */
    private array $items = [];

    /**
     * @return InpostPoint[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param InpostPoint[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }
}