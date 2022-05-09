<?php

namespace App\Exceptions\Session;

use Illuminate\Http\Response;

class SessionNotDisabled extends SessionException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.session.not-disabled'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
