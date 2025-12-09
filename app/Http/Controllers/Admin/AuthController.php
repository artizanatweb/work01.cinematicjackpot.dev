<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request): Response
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'error' => 'Invalid credentials!',
            ], Response::HTTP_UNAUTHORIZED);
        }

        /** @var User $user */
        $user = Auth::user();
        $jwt = $user->createToken('token')->plainTextToken;
        $cookie = cookie('jwt', $jwt, 60 * 24);

        return response([
            'message' => "success",
        ])->withCookie($cookie);
    }

    public function logout(): Response
    {
        $cookie = Cookie::forget('jwt');
        session()->flush();

        return response([
            'message' => "success",
        ])->withCookie($cookie);
    }

    public function user(Request $request)
    {
//        dd($request->user());
        return $request->user();
    }
}
