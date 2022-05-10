<?php

namespace App\Repositories;

use App\Types\SessionStatusTypes;
use App\Exceptions\Session\{
    SessionNotStored,
    SessionNotUpdated,
};
use App\Models\{
    Session,
    User,
};
use Carbon\Carbon;
use Illuminate\Support\Str;

class SessionRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(Session::class);
    }

    /**
     * @param User $user
     * @return Session
     * @throws SessionNotStored
     */
    public function store(User $user): Session
    {
        try {
            return $user->session()->create([
                'auth_secure_token' => Str::uuid()->toString(),
                'status' => 'active',
                'expired_at' => Carbon::now()->addMinutes(config('app.session_ttl'))->format('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            throw new SessionNotStored($e);
        }
    }

    /**
     * @param Session $session
     * @return void
     * @throws SessionNotUpdated
     */
    public function disableSessions(Session $session)
    {
        try {
            Session::where('id', '<>', $session->id)
                ->where('user_id', $session->user_id)
                ->where('status', SessionStatusTypes::ACTIVE)
                ->update([
                    'status' => SessionStatusTypes::INACTIVE,
                    'disabled_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
        } catch (\Exception $e) {
            throw new SessionNotUpdated($e);
        }
    }

    /**
     * @param Session $session
     * @return bool
     * @throws SessionNotUpdated
     */
    public function disableSession(Session $session): bool
    {
        try {
            return $session->update([
                'status' => 'inactive',
                'disabled_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            throw new SessionNotUpdated($e);
        }
    }

    /**
     * @param string $auth_secure_token
     * @return Session
     */
    public function getSessionByAuthSecureToken(string $auth_secure_token): Session
    {
        return Session::where('auth_secure_token', $auth_secure_token)
            ->where('status', 'active')
            ->where('expired_at', '>', Carbon::now()->format('Y-m-d H:i:s'))
            ->first();
    }
}
