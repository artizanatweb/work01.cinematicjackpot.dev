<?php

namespace App\Services\Admin;

use App\Exceptions\AdminOtpException;
use App\Mail\AdminOtpEmail;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Support\Facades\Cookie as SessionCookie;
use App\Entities\AdminCredentialsEntity;
use App\Enums\TwoFactorAuthType;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public function __construct(
        private readonly UserRepository $repository
    ) {}

    private function getUser(AdminCredentialsEntity $credentials, bool $validate = false): User
    {
        $provider = Auth::getProvider();

        /** @var ?User $user */
        $user = $provider->retrieveByCredentials($credentials->toArray());
        if (!$user) {
            throw new Exception("User with email {$credentials->getEmail()} not found in database!");
        }
        if (!$user->isAdmin()) {
            throw new Exception("User with email {$user->email} is not ADMIN!");
        }

        if (!$validate) {
            return $user;
        }

        if (!$provider->validateCredentials($user, $credentials->toArray())) {
            throw new Exception("Invalid password for user {$user->email}!");
        }

        return $user;
    }

    private function sendOtpEmail(User $user): void
    {
//        dd($user->profile->otp_code);
        Mail::to($user)->send(new AdminOtpEmail($user));
    }

    public function verify2FA(AdminCredentialsEntity $credentials): void
    {
        $user = $this->getUser($credentials, true);

        if (TwoFactorAuthType::Email === $user?->profile?->two_factor_auth) {
            // generate 6 digits otp code and add it to profile
            $this->repository->generateOtp($user);
            // send OTP code on email
            $this->sendOtpEmail($user);

            throw new AdminOtpException(TwoFactorAuthType::Email->value);
        }

        if (TwoFactorAuthType::Authenticator === $user?->profile?->two_factor_auth) {
            throw new AdminOtpException(TwoFactorAuthType::Authenticator->value);
        }
    }

    public function signIn(AdminCredentialsEntity $credentials, bool $remember = false): Cookie
    {
        if (!Auth::attempt($credentials->toArray(), $remember)) {
            throw new Exception('Invalid credentials!');
        }

        /** @var Request $request */
        $request = request();
        $request->session()->regenerate();

        /** @var User $user */
        $user = Auth::user();
        $jwt = $user->createToken('token')->plainTextToken;

        return cookie('jwt', $jwt, 60 * 24);
    }

    public function signOut(): Cookie
    {
        /** @var Request $request */
        $request = request();

        Auth::logout();
        $cookie = SessionCookie::forget('jwt');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $cookie;
    }

    public function validateProfileOtp(AdminCredentialsEntity $credentials, $otpCode)
    {
        $user = $this->getUser($credentials);

    }

    public function validateAuthenticatorOtp()
    {
        //
    }
}
