<?php

namespace App\Http\Middleware\User;

use Closure;
use Illuminate\Http\Request;
use Infrastructure\Enums\RolesEnum;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->hasRole(RolesEnum::ADMIN->value)){
            return $next($request);
        }

        return redirect('/');
    }
}
