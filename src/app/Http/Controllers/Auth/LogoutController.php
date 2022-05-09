<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Exceptions\Session\{
    SessionExpired,
    SessionNotDisabled,
    SessionNotUpdated
};
use App\Helpers\ResponseHelper;
use App\Repositories\{
    Repository,
    SessionRepository
};
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    private Repository $repository;

    public function __construct()
    {
        $this->repository = new SessionRepository();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws SessionExpired
     * @throws SessionNotDisabled
     * @throws SessionNotUpdated
     */
    public function logout(Request $request): JsonResponse
    {
        if (!$session = $this->repository->getSessionByAuthSecureToken($request->header('Auth-Secure-Token')))
            throw new SessionExpired();

        if (!$this->repository->disableSession($session))
            throw new SessionNotDisabled();

        return ResponseHelper::results(['message' => trans('auth.logged_out')]);
    }
}
