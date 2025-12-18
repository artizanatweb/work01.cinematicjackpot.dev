<?php

namespace App\Models;

use App\Enums\TwoFactorAuthType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $casts = [
        'two_factor_auth' => TwoFactorAuthType::class,
        'otp_expires_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class,'language_id');
    }
}
