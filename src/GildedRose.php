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

    public function updateBrie($item)
    {
        $factor = $item->sellIn <= 0 ? 2 : 1;
        $item->quality += $factor;
        $item->quality = $item->quality > 50 ? 50 : $item->quality;

        $item->sellIn--;
    }

    public function updateBackstagePass($item)
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

            $item->quality += $factor;
            $item->quality = $item->quality > 50 ? 50 : $item->quality;
        }
        $item->sellIn--;
    }

    public function updateSulfuras($item)
    {
    }

    public function updateConjured($item)
    {
        $item->quality -= 2;
        $item->quality = $item->quality < 0 ? 0 : $item->quality;
        $item->sellIn--;
    }

    public function updateGeneralItems($item)
    {
        if ($item->quality > 0) {
            $factor = $item->sellIn <= 0 ? 2 : 1;
            $item->quality -= $factor;
            $item->quality = $item->quality < 0 ? 0 : $item->quality;
        }
        $item->sellIn--;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
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
}
