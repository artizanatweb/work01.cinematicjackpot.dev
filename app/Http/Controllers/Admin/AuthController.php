<?php

namespace App\Http\Controllers\Admin;

use App\Entities\AdminCredentialsEntity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Resources\ErrorResource;
use App\Services\Admin\AuthService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\AdminOtpException;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $service
    ) {}

    public function login(LoginRequest $request): Response | JsonResource
    {
        $data = $request->validated();
        try {
            $credentials = new AdminCredentialsEntity($data);
            $this->service->verify2FA($credentials);
            $cookie = $this->service->signIn($credentials);
        } catch (AdminOtpException $otpe) {
            // return OTP screen for type:
            dd($otpe->getType());
        } catch (Exception $e) {
            Log::error($e->getMessage());

//            return response([
//                'error' => 'Invalid credentials!',
//            ], Response::HTTP_UNAUTHORIZED);

            return new ErrorResource('Invalid credentials!', Response::HTTP_UNAUTHORIZED);
        }

        return response([
            'message' => "success",
        ])->withCookie($cookie);
    }

    public function logout(): Response
    {
        $cookie = $this->service->signOut();

        return response([
            'message' => "success",
        ])->withCookie($cookie);
    }

    public function otpLogin(LoginRequest $request)
    {
        $data = $request->validated();

    }

    public function otpEmail()
    {
        // email and password must be saved in global state and send to this method alongside the Email One-time Password
    }

    public function otpAuthenticator()
    {
        // email and password must be saved in global state and send to this method alongside the Authenticator One-time Password
    }

    public function user(Request $request)
    {
        return $request->user();
    }
}
