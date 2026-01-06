<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckStaffPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        $user = Auth::user();

        // If logged in as admin or mosque user, allow full access
        if ($user->role === 'admin' || $user->role === 'mosque') {
            return $next($request);
        }

        // If logged in as staff, check permissions
        if ($user->role === 'staff') {
            // Check if staff is active
            if (!$user->is_active) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Your account has been deactivated.');
            }

            // Check if staff has any of the required permissions
            if (empty($permissions) || $user->hasAnyPermission($permissions)) {
                return $next($request);
            }

            // Staff doesn't have permission
            return redirect()->route('mosque.dashboard')->with('error', 'You do not have permission to access this page.');
        }

        return redirect()->route('login')->with('error', 'Access denied.');
    }
}
