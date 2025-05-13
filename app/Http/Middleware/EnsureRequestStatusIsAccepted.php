<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class EnsureRequestStatusIsAccepted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->request_status !== 'accepted') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return match ($user->request_status) {
                'pending' => redirect()->route('register_pending'),
                'rejected' => redirect()->route('register_rejected'),
                default => abort(403, 'Unauthorized'),
            };
        }

        return $next($request);
    }
}
