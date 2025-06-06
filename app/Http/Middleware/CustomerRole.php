<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user= auth('sanctum')->user();
        if($user->role != 'customer') {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized',
            ], 401);
        }
        return $next($request);
    }
}
