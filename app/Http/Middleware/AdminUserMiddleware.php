<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;

class AdminUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User $user */
        $user = auth()->user();
        if ($user?->active) {
            if ($user->hasRole('admin')) {
                return $next($request);
            }
        }

        $cookie = Cookie::forget('jwt');
        session()->invalidate();
        session()->regenerateToken();

        return response([
            'message' => "Access denied!",
        ], Response::HTTP_FORBIDDEN)->withCookie($cookie);
    }
}
