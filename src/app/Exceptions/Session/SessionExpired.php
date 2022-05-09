<?php

namespace App\Exceptions\Session;


use Illuminate\Http\Response;

class SessionExpired extends SessionException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.session.expired'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
