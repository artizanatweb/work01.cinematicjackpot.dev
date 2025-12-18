<?php

namespace App\Repositories;

use App\Entities\AdminUserEntity;
use App\Enums\TwoFactorAuthType;
use App\Models\User;
use App\Models\Profile;

class UserRepository implements Interfaces\UserRepository
{

    public function findByEmail(string $email): ?User
    {
        return User::whereEmail($email)->first();
    }

    public function createAdmin(AdminUserEntity $entity): User
    {
        $user = new User();
        $user->name = $entity->name;
        $user->email = $entity->email;
        $user->password = bcrypt($entity->password);
        $user->active = $entity->active;
        $user->saveOrFail();

        $profile = new Profile();
        if ($entity?->phone) {
            $profile->phone = $entity->phone;
        }
        if ($entity?->language) {
            $profile->language_id = $entity->language?->id;
        }
        if ($entity?->emailAuthentication) {
            $profile->two_factor_auth = TwoFactorAuthType::Email->value;
        }
        $user->profile()->save($profile);

        return $user;
    }

    public function updateAdmin(User $user, AdminUserEntity $entity): void
    {
        $user->name = $entity->name;
        $user->email = $entity->email;
        $user->password = bcrypt($entity->password);
        $user->active = $entity->active;
        $user->saveOrFail();

        $profile = $user->profile;
        $profile->phone = $entity->phone;
        if ($entity?->language) {
            $profile->language_id = $entity->language?->id;
        }
        if ($entity?->emailAuthentication) {
            $profile->two_factor_auth = TwoFactorAuthType::Email->value;
        }
        $user->profile()->save($profile);
    }

    public function setAdmins2FA(bool $active = true): int
    {
        // get admin role
//        $role = Role::with(['users'])->where('slug','=','admin')->first();
        // update role users column has_email_authentication with received active value
//        return $role->users()->update(['has_email_authentication' => $active]);
        return 1;
    }

    public function generateOtp(User $user): void
    {

        $code32 = [];
        for ($c = 0; $c < 32; $c++) {
            $digit = rand(0,9);
            $code32[] = $digit;
        }

        $otpArray = [];
        for ($i = 0; $i < 6; $i++) {
            $p = rand(0,31);
            $otpArray[] = $code32[$p];
        }

        $otp = implode($otpArray);
        $otpAvailability = (int) env('OTP_AVAILABILITY_MINUTES', 5);

        $profile = $user->profile;
        $profile->otp_code = $otp;
        $profile->otp_expires_at = now()->addMinutes($otpAvailability);
        $user->profile()->save($profile);
    }
}
