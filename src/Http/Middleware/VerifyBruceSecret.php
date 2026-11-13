<?php

namespace WebBestPractice\BruceChat\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyBruceSecret
{
    public function handle(Request $request, Closure $next): Response
    {
        $configured = (string) config('bruce-chat.secret');

        if ($configured === '') {
            return response()->json([
                'message' => 'Bruce chat secret is not configured.',
            ], 503);
        }

        $provided = (string) (
            $request->bearerToken()
            ?? $request->header('X-Bruce-Secret')
            ?? ''
        );

        if (! hash_equals($configured, $provided)) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);
        }

        return $next($request);
    }
}
