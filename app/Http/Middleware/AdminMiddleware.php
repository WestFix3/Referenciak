<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::debug('Admin Middleware: Checking user rights...');
    
        if (!Auth::check()) {
            Log::debug('User not authenticated');
            return redirect()->route('login');
        }

        $user = Auth::user();
        if (!$user->admin) {
            Log::debug('User is not admin');
            return abort(403, 'Unauthorized action.');
        }

        Log::debug('User is admin, continuing request...');
        return $next($request);
    }
}
