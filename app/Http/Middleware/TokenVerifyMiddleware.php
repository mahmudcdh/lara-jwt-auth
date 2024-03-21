<?php

namespace App\Http\Middleware;

use App\Helper\JWToken;
use Closure;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response;

class TokenVerifyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('token');
        $tokenResult = JWToken::verifyToken($token);

        if($tokenResult == 'unauthorized') {
            return redirect('/login');
        }else{
            $request->headers->set('email', $tokenResult->email);
            $request->headers->set('id', $tokenResult->id);

            // foreach ($tokenResult->userData as $key => $value) {
            //     $request->headers->set($key, $value);
            // }
            // $request->headers->set('email', $tokenResult->userData->email);

            return $next($request);
        }

    }
}
