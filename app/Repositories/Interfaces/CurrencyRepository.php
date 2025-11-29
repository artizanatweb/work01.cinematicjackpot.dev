<?php

namespace App\Repositories\Interfaces;

use App\Models\Currency;

interface CurrencyRepository
{
    public function findByAlphaCode(string $code): ?Currency;

    public function findByNumCode(string $code): ?Currency;

    public function make(string $alphabeticCode, string $numericCode, string $name, string $symbol): Currency;
}
