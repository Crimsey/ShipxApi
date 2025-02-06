<?php

namespace App\Entity;

class InpostPoint
{
    private int $count;
    private int $page;
    private int $totalPages;
    private array $items;

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function setTotalPages(int $totalPages): void
    {
        $this->totalPages = $totalPages;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    //@todo tu sę zawahałem przez liczbę pojedynczą w zadaniu "serializer powinien przekształcić do modelu klasy następujące parametry"
    //rozumiem że modelu 1 klasy?
    //przyszłościowo przydałaby się oddzielna Encja dla adresu punktu InpostPointAddress i oddzielnie byśmy go serializowali
    public function setItems(array $items): void
    {
        $filteredItems = [];
        foreach ($items as $item) {
            $filteredItems[] = [
                'name' => $item['name'] ?? '',
                'address' => isset($item['address']) ? ($item['address']['line1'] . ' ' . $item['address']['line2']) : '',
            ];
        }
        $this->items = $filteredItems;
    }
}