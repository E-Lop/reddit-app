<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {

        try {

            auth()->user()->id;
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Non sei autenticato",
                "error_code" => '401'
            ], 401);
        }
        return $next($request);
    }
}
