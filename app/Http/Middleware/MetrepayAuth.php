<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class MetrepayAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $basicAuthData = $request->header('Authorization');

        if (stripos($basicAuthData, 'basic ') === 0) {
            $basicAuthDataExploded = explode(':', base64_decode(substr($basicAuthData, 6)), 2);
            if (count($basicAuthDataExploded) === 2) {

                list($user, $password) = $basicAuthDataExploded;

                if($user === config('metrepay.user') && $password === config('metrepay.password')) {
                    return $next($request);
                }

            }
        }

        return response()->json(['error' => 'Unauthenticated.'], 401);
    }
}
