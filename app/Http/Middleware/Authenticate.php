<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // for admin routes --> because in app.php then: routes have name like "something."
        if ($request->routeIs('admin*')) {
            return route('admin.login');
        }

        // Normal users fallback
        return route('login');
    }
}
