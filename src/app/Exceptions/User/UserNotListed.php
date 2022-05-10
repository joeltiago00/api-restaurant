<?php

namespace App\Exceptions\User;


use Illuminate\Http\Response;

class UserNotListed extends UserException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.not-listed'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
