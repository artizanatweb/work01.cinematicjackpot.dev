<?php

namespace App\Services\Admin;

use App\Entities\AdminCredentialsEntity;
use App\Enums\TwoFactorAuthType;
use App\Models\User;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Support\Facades\Auth;
use Exception;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Support\Facades\Cookie as SessionCookie;

class AuthService
{
    public function __construct(
        private readonly UserRepository $repository
    ) {}

    public function check2fa(string $email): void
    {
        $user = $this->repository->findByEmail($email);
        if (!$user) {
            throw new Exception('User not found!');
        }

        switch ($user?->profile?->two_factor_auth) {
            case TwoFactorAuthType::Email:
                $this->sendOtpEmail();
                return;
            case TwoFactorAuthType::Authenticator:
                $this->requestAuthenticatorOtp();
                return;
            default:
                break;
        }
    }

    public function authenticate(AdminCredentialsEntity $credentials, bool $remember = false): Cookie
    {
        if (!Auth::attempt($credentials->toArray())) {
            throw new Exception('Invalid credentials!');
        }

        /** @var User $user */
        $user = Auth::user();
        $jwt = $user->createToken('token')->plainTextToken;

        return cookie('jwt', $jwt, 60 * 24);
    }

    public function deauthenticate(): Cookie
    {
        $cookie = SessionCookie::forget('jwt');
        session()->flush();

        return $cookie;
    }

    private function sendOtpEmail(): void
    {
        // One-time Password
    }

    private function requestAuthenticatorOtp()
    {
        // google Authenticator One-time Password
    }
}
