<?php

namespace App\Repositories\Interfaces;

use App\Enums\ProductSignageType;
use App\Models\Language;
use App\Models\ProductSignage;

interface ProductSignageRepository
{
    public function add(string $name, string $color, ProductSignageType $type): ProductSignage;

    public function addValue(ProductSignage $signage, Language $language, string $value): void;
}