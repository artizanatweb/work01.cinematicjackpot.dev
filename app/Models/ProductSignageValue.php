<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read \App\Models\Language|null $language
 * @property-read \App\Models\ProductSignage|null $signal
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSignageValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSignageValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductSignageValue query()
 * @mixin \Eloquent
 */
class ProductSignageValue extends Model
{
    public $timestamps = false;

    public function signal(): BelongsTo
    {
        return $this->belongsTo(ProductSignage::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
