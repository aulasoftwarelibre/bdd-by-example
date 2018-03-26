<?php
declare(strict_types=1);

namespace Restaurant;

class Menu implements Priced
{
    private $number;
    private $price;

    public function __construct(int $number, int $price)
    {
        $this->number = $number;
        $this->price = $price;
    }

    public function number(): int
    {
        return $this->number;
    }

    public function price(): int
    {
        return $this->price;
    }
}
