<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // ユーザーがログインしており、かつis_adminが1の場合にのみ次のミドルウェアまたはコントローラに進む
        if ($request->user() && $request->user()->is_admin == 1) {
            return $next($request);
        }

        // それ以外の場合はアクセス拒否
        abort(403, 'Unauthorized');
    }
}
