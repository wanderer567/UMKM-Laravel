<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
{
    // Menggunakan $request untuk mengecek user yang sedang login
    if ($request->user() && $request->user()->role === 'admin') {
        return $next($request);
    }

    // Jika bukan admin, lempar kembali ke home
    return redirect()->route('home')->with('error', 'Anda tidak memiliki akses admin.');
}
}