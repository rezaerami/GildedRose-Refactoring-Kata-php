<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    /**
     * @param Item[] $items
     */
    public function __construct(
        private array $items
    ) {
    }

    private function adjustQuality(Item $item, int $amount): void
    {
        $item->quality += $amount;
        if ($item->quality > 50) {
            $item->quality = 50;
        } elseif ($item->quality < 0) {
            $item->quality = 0;
        }
    }

    private function decrementSellIn(Item $item): void
    {
        $item->sellIn--;
    }

    private function updateBrie(Item $item): void
    {
        $factor = $item->sellIn <= 0 ? 2 : 1;
        $this->adjustQuality($item, $factor);
        $this->decrementSellIn($item);
    }

    private function updateBackstagePass(Item $item): void
    {
        if ($item->sellIn <= 0) {
            $item->quality = 0;
        } else {
            $factor = 1;
            if ($item->sellIn <= 10) {
                $factor = 2;
            }
            if ($item->sellIn <= 5) {
                $factor = 3;
            }
            $this->adjustQuality($item, $factor);
        }
        $this->decrementSellIn($item);
    }

    private function updateSulfuras(Item $item): void
    {
        // Sulfuras doesn't need updating
    }

    private function updateConjured(Item $item): void
    {
        $this->adjustQuality($item, -2);
        $this->decrementSellIn($item);
    }

    private function updateGeneralItems(Item $item): void
    {
        $factor = $item->sellIn <= 0 ? 2 : 1;
        $this->adjustQuality($item, -$factor);
        $this->decrementSellIn($item);
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $this->updateItem($item);
        }
    }

    private function updateItem(Item $item): void
    {
        switch ($item->name) {
            case 'Aged Brie':
                $this->updateBrie($item);
                break;
            case 'Backstage passes to a TAFKAL80ETC concert':
                $this->updateBackstagePass($item);
                break;
            case 'Sulfuras, Hand of Ragnaros':
                $this->updateSulfuras($item);
                break;
            case 'Conjured Mana Cake':
                $this->updateConjured($item);
                break;
            default:
                $this->updateGeneralItems($item);
        }
    }
}
