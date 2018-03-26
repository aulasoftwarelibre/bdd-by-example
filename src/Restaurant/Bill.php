<?php
declare(strict_types=1);

namespace Restaurant;

class Bill
{
    const VAT = '1.10';
    private $items;
    private $amount;
    private $points;

    public function __construct()
    {
        $this->items = [];
        $this->points = 0;
        $this->amount = 0;
    }

    public function getTotal(): int
    {
        return (int) round($this->totalWithoutVAT() * self::VAT);
    }

    public function addItem(Priced $item): void
    {
        $this->items[] = $item;
    }

    public function payWithMoney(int $amount): void
    {
        $this->amount = $amount;
    }

    public function restToPay(): int
    {
        return $this->getTotal() - $this->amount - $this->getMoneyPoints();
    }

    public function getPoints(): int
    {
        if ($this->points > 0) {
            return 0;
        }

        return (int) floor($this->totalWithoutVAT() / 100);
    }

    private function totalWithoutVAT(): int
    {
        return array_reduce($this->items, function ($carry, Priced $priced) {
            return $carry + $priced->price();
        }, 0);
    }

    public function payWithPoints(int $points): void
    {
        $this->points = $points;
    }

    private function getMoneyPoints(): int
    {
        $maxMoneyPoints = $this->totalWithoutVAT();
        $moneyPoints = 100 * $this->points / 10;

        return $moneyPoints > $maxMoneyPoints ? $maxMoneyPoints : $moneyPoints;
    }
}
