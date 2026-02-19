<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  The required role (e.g. 'admin')
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Get the currently authenticated user (via Sanctum token)
        $user = $request->user();

        // Check if the user belongs to at least one organization
        // where the pivot role matches the required role
        $hasRole = $user->organizations()
            ->wherePivot('role', $role)
            ->exists();

        if (!$hasRole) {
            // Return 403 if user does not have the required role
            return response()->json([
                'message' => 'Forbidden: insufficient role'
            ], 403);
        }

        // Continue the request if the role check passes
        return $next($request);
    }
}
