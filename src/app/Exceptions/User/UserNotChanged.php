<?php

namespace App\Exceptions\User;

use Illuminate\Http\Response;

class UserNotChanged extends UserException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.not-changed'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
