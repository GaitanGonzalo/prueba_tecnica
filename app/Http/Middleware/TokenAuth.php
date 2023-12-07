<?php

namespace App\Http\Middleware;

use App\Helpers\Token;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //check token
        $token = $request->bearerToken();
        if(!$token) return response()->json('Unauthorized', 401);
        $result = Token::decodeToken($token);
        if(!empty($result['statusCode'])) return response()->json(['message'=>$result['message']], 401);
        return $next($request);
    }
}
