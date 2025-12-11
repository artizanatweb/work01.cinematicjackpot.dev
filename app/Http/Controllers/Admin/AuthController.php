<?php

namespace App\Http\Controllers\Admin;

use App\Entities\AdminCredentialsEntity;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\Admin\AuthService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Exception;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $service
    ) {}

    public function login(LoginRequest $request): Response
    {
        try {
            $this->service->check2fa($request->post('email'));
            $credentials = new AdminCredentialsEntity($request->only('email', 'password'));
            $cookie = $this->service->authenticate($credentials);
        } catch (Exception $e) {
            return response([
                'error' => 'Invalid credentials!',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response([
            'message' => "success",
        ])->withCookie($cookie);
    }

    public function logout(): Response
    {
        $cookie = $this->service->deauthenticate();

        return response([
            'message' => "success",
        ])->withCookie($cookie);
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
