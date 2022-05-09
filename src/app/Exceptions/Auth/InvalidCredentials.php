<?php

namespace App\Exceptions\Auth;


use Illuminate\Http\Response;

class InvalidCredentials extends AuthException
{
    public function __construct()
    {
        parent::__construct(
            trans('auth.invalid-credentials'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
