<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = '$2y$10$h6ip6YtFQ1H6hk.0qQ9cD.StnRLbHoSezBDkaXjdMpxvEpBLNQVym';
        if ($request->header('x-api-key') === $apiKey) {
            return $next($request);
        } else {
            return response()->json(['alert' => 'Invalid api key'], 500);
        }
    }
}
