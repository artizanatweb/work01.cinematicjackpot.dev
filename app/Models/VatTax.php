<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon $date
 * @property int $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VatTax newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VatTax newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VatTax query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VatTax whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VatTax whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VatTax whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VatTax whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VatTax whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class VatTax extends Model
{
    protected $casts = [
        'date' => 'date',
    ];
}
