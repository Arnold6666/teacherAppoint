<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VertifyDomainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedDomains = ['example.com', 'subdomain.example.com'];

        $origin = $request->header('Origin');

        if (in_array($origin, $allowedDomains)) {
            return $next($request);
        }

        return response()->json([
            'status' => false,
            'message' => 'Access denied.'
        ], 403);
        
        return $next($request);
    }
}
