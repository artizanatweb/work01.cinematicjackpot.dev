<?php

namespace App\Models;

use App\Enums\ProductSignageType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductSignageValue> $values
 * @property-read int|null $values_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSignage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSignage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSignage query()
 * @mixin \Eloquent
 */
class ProductSignage extends Model
{
    public $timestamps = false;

    protected $casts = [
        'type' => ProductSignageType::class,
    ];

    public function values(): HasMany
    {
        return $this->hasMany(ProductSignageValue::class);
    }

    public function adminValue(): HasOne
    {
        $languageId = admin_language_id();
        return $this->hasOne(ProductSignageValue::class)->where('language_id', $languageId);
    }
}
