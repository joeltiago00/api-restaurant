<?php

namespace App\Http\Middleware;

use App\Exceptions\Access\AccessDenied;
use App\Exceptions\JobFunction\JobFunctionNotFound;
use App\Exceptions\User\InvalidUser;
use App\Repositories\UserRepository;
use Closure;

class Waiter
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws AccessDenied
     * @throws InvalidUser
     * @throws JobFunctionNotFound
     */
    public function handle($request, Closure $next)
    {
        if (!$user = (new UserRepository())->getById($request->user_id))
            throw new InvalidUser();

        if (!(new UserRepository())->isWaiter($user))
            throw new AccessDenied();

        return $next($request);
    }
}
