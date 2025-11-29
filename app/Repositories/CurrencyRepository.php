<?php

namespace App\Repositories;

use App\Models\Currency;

class CurrencyRepository implements Interfaces\CurrencyRepository
{

    public function make(string $alphabeticCode, string $numericCode, string $name, string $symbol): Currency
    {
        $currency = $this->findByAlphaCode($alphabeticCode);
        if (!$currency) {
            $currency = new Currency();
        }

        $currency->alphabetic_code = $alphabeticCode;
        $currency->numeric_code = $numericCode;
        $currency->name = $name;
        $currency->symbol = $symbol;
        $currency->saveOrFail();

        return $currency;
    }

    public function findByAlphaCode(string $code): ?Currency
    {
        return Currency::where('alphabetic_code', '=', $code)->first();
    }

    public function findByNumCode(string $code): ?Currency
    {
        return Currency::where('numeric_code', '=', $code)->first();
    }
}
