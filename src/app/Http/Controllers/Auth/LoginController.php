<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Exceptions\Auth\InvalidCredentials;
use App\Exceptions\JobFunction\JobFunctionNotFound;
use App\Exceptions\Role\RoleNotFound;
use App\Helpers\ResponseHelper;
use App\Models\Role;
use App\Repositories\JobFunctionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Exceptions\Session\{
    SessionNotStored,
    SessionNotUpdated,};
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Repositories\SessionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * @var SessionRepository
     */
    private SessionRepository $repository;

    public function __construct()
    {
        $this->repository = new SessionRepository();
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws InvalidCredentials
     * @throws JobFunctionNotFound
     * @throws RoleNotFound
     * @throws SessionNotStored
     * @throws SessionNotUpdated
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user)
            throw new InvalidCredentials();

        if (!$this->validatePassword($user->password, $request->password))
            throw new InvalidCredentials();

        $session = $this->repository->store($user);

        $this->repository->disableSessions($session);

        if (!$role = (new RoleRepository())->getById($user->role_id))
            throw new RoleNotFound();

        if (!$job = (new JobFunctionRepository())->getById($user->job_function_id))
            throw new JobFunctionNotFound();

        return ResponseHelper::results([
            'user' => [
                'id' => $user->id,
                'name' => sprintf('%s %s', $user->first_name, $user->last_name),
                'email' => $user->email,
                'user_job_function_id' => $user->job_function_id,
                'user_job_function_name' => $job->name,
                'user_role_id' => $role->id,
                'user_role_name' => $role->name,
                'user_is_admin' => (new UserRepository())->isAdmin($user)
            ],
            'session' => [
                'auth_secure_token' => $session->auth_secure_token,
                'expired_at' => $session->expired_at
            ]
        ]);

    }

    /**
     * @param string $user_password
     * @param string $request_password
     * @return bool
     */
    public function validatePassword(string $user_password, string $request_password): bool
    {
        return Hash::check($request_password, $user_password);

    }
}
