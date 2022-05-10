<?php

namespace App\Exceptions\User;


use Illuminate\Http\Response;

class UserNotExcluded extends UserException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.user.not-excluded'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
