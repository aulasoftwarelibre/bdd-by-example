<?php
declare(strict_types=1);

namespace Restaurant;

interface Priced
{
    public function price(): int;
}