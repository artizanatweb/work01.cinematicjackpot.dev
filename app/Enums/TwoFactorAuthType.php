<?php

namespace App\Enums;

enum TwoFactorAuthType: string
{
    case None = '';

    case Email = 'email';

    case Authenticator = 'authenticator';

    public function label(): string
    {
        return match ($this) {
            self::None => __("Without 2FA"),
            self::Email => __("Email address"),
            self::Authenticator => __("Google Authenticator application"),
        };
    }
}
