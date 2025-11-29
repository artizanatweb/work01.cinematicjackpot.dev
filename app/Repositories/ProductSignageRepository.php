<?php

namespace App\Repositories;

use App\Enums\ProductSignageType;
use App\Models\Language;
use App\Models\ProductSignage;
use App\Models\ProductSignageValue;

class ProductSignageRepository implements Interfaces\ProductSignageRepository
{

    public function add(string $name, string $color, ProductSignageType $type): ProductSignage
    {
        $signage = new ProductSignage();
        $signage->name = $name;
        $signage->color = $color;
        $signage->type = $type;
        $signage->saveOrFail();

        return $signage;
    }

    public function addValue(ProductSignage $signage, Language $language, string $value): void
    {
        $signageValue = new ProductSignageValue();
        $signageValue->product_signage_id = $signage->id;
        $signageValue->language_id = $language->id;
        $signageValue->value = $value;
        $signageValue->saveOrFail();
        $signage->values->add($signageValue);
    }
}