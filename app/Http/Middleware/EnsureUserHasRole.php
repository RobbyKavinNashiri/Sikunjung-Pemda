<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Peran pemohon: dicek lewat guard pemohon
        if ($role === 'pemohon') {
            if (! Auth::guard('pemohon')->check()) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
            }
            return $next($request);
        }

        // Peran admin / penduduk: dicek lewat guard penduduk
        $user = Auth::guard('penduduk')->user();

        if (! $user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $statusDiminta = $role === 'admin' ? 'Admin' : 'Penduduk';

        if ($user->status !== $statusDiminta) {
            abort(403, 'Anda tidak berhak mengakses halaman ini.');
        }

        return $next($request);
    }
}