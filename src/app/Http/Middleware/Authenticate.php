<?php

namespace App\Http\Middleware;

use App\Exceptions\JobFunction\JobFunctionNotFound;
use App\Exceptions\Role\RoleNotFound;
use App\Exceptions\Session\InvalidSession;
use App\Exceptions\User\InvalidUser;
use App\Models\Session;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class Authenticate extends Middleware
{
    /**
     * @param $request
     * @param \Closure $next
     * @param ...$guards
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws InvalidSession
     * @throws InvalidUser
     * @throws JobFunctionNotFound
     * @throws RoleNotFound
     */
    public function handle($request, \Closure $next, ...$guards)
    {
        $token = $request->header('Auth-Secure-Token');

        $validation = Validator::make(
            ['Auth-Secure-Token' => $token],
            [
                'Auth-Secure-Token' => 'required|uuid',
            ]);

        if ($validation->fails()) {
            return \response()->json(['errors' => $validation->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!$session = Session::where('auth_secure_token', $token)
            ->where('status', 'active')
            ->where('expired_at', '>', Carbon::now()->format('Y-m-d H:i:s'))
            ->first())
            throw new InvalidSession();


        if (!$user = $session->user()->first())
            throw new InvalidUser();

        if (!$role = $user->role()->first())
            throw new RoleNotFound();

        if (!$job = $user->jobFunction()->first())
            throw new JobFunctionNotFound();

        $request->merge([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_job_function_id' => $user->job_function_id,
            'user_job_function_name' => $job->name,
            'user_role_id' => $user->role_id,
            'user_role_name' => $role->name,
            'user_is_admin' => (new UserRepository())->isAdmin($user),
            'session_id' => $session->id
        ]);

        return $next($request);
    }
}
