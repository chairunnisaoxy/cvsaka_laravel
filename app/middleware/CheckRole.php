<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::guard('karyawan')->user();

        if (!$user) {
            return redirect()->route('login')->withErrors('Silakan login terlebih dahulu.');
        }

        if (!in_array($user->jabatan, $roles)) {
            abort(403, 'Akses ditolak. Hanya untuk ' . implode(', ', $roles));
        }

        return $next($request);
    }
}
