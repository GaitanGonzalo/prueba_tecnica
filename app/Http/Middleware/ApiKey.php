<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-Api-Key');
        dump($request);
        dd($apiKey);
        if(empty($apiKey) || config('app.api_key') != $apiKey) return response()->json(['message'=>'Forbidden'], 403);
        return $next($request);
        
    }
}
