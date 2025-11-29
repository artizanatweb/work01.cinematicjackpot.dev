<?php

namespace App\Repositories\Interfaces;

use App\Interface\FindModelByCode;
use App\Models\Currency;
use App\Models\Language;

interface LanguageRepository extends FindModelByCode
{
    public function make(string $code, string $name, Currency $currency, ?int $id = null): Language;
}
