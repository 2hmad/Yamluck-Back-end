<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifyAdminToken
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
        if ($request->header('token') !== '') {
            $token = $request->header('token');
            $checkToken = DB::table('admins')->where('token', '=', $token)->first();
            if ($checkToken !== null) {
                return $next($request);
            } else {
                return response()->json(['alert' => 'Admin Token Not Found'], 404);
            }
        }
    }
}
