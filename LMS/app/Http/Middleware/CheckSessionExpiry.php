<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionExpiry
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user sudah login, update last_login
        if (Auth::check()) {
            $user = Auth::user();
            
            // Update last_login setiap 5 menit untuk menghindari terlalu sering update
            $lastUpdate = session('last_activity_update', 0);
            $now = time();
            
            if ($now - $lastUpdate > 300) { // 5 menit
                $user->update(['last_login' => now()]);
                session(['last_activity_update' => $now]);
            }
        }
        
        return $next($request);
    }
}