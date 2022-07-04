<?php

namespace FatemeMahmoodi\LaravelToDo\Http\Middleware;

use FatemeMahmoodi\LaravelToDo\Models\User;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

class TokenAuthorize
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('Authorization') === null)
            throw new AuthorizationException();

        if ($this->isValidToken($request->header('Authorization')) === false)
            throw new AuthorizationException();

        return $next($request);

    }

    private function isValidToken($token)
    {
        $user = config('laravel_todo.task_owner')
            ::where(
                'token', $this->parseToken($token)
            )
            ->first();
        if ($user === null) {
            return false;
        }

        Auth::setUser($user);
        return true;
    }

    private function parseToken($token)
    {
        return str_replace('Bearer ', '', $token);
    }
}
