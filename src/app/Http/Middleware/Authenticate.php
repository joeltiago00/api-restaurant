<?php

namespace App\Http\Middleware;

use App\Exceptions\Login\LoginInvalidSessionException;
use App\Exceptions\Session\InvalidSession;
use App\Exceptions\User\InvalidUser;
use App\Exceptions\User\UserInvalidException;
use App\Models\Session;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
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

        $session = Session::where('auth_secure_token', $token)
            ->where('status', 'active')
            ->where('expired_at', '>', Carbon::now()->format('Y-m-d H:i:s'))
            ->first();

        if (!$session) {
            throw new InvalidSession();
        }

        $user = $session->user()->first();

        if (!$user)
            throw new InvalidUser();


        $request->merge([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_job_function' => $user->job_function_id,
            'user_role_id' => $user->role_id,
            'user_is_admin' => (new UserRepository())->isAdmin($user),
            'session_id' => $session->id
        ]);

        return $next($request);
    }
}
