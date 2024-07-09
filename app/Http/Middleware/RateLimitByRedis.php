<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class RateLimitByRedis
{
    public const MAX_ATTEMPTS = 5;
    public const DECAY_MINUTES = 1;

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $key = $this->resolveRequestSignature($request);

        if (Redis::command('INCR', [$key]) > self::MAX_ATTEMPTS) {
            return response('Too Many Attempts.', Response::HTTP_TOO_MANY_REQUESTS);
        }

        if (Redis::command('GET', [$key]) === 1) {
            Redis::command('EXPIRE', [$key, self::DECAY_MINUTES * 60]);
        }

        return $next($request);
    }

    /**
     * Resolve request signature.
     *
     */
    protected function resolveRequestSignature(Request $request): string
    {
        return sha1(
            $request->method() .
            '|' . $request->server('SERVER_NAME') .
            '|' . $request->path() .
            '|' . $request->ip()
        );
    }
}
