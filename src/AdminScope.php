<?php

declare(strict_types=1);

namespace Microservices;

use Closure;
use Illuminate\Auth\AuthenticationException;

class AdminScope
{
    public function __construct(
        private readonly UserService $userService
    )
    {
        //
    }

    /**
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        if ($this->userService->isAdmin()) {
            return $next($request);
        }

        throw new AuthenticationException;
    }
}