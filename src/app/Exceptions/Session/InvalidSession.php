<?php

namespace App\Exceptions\Session;

use Illuminate\Http\Response;

class InvalidSession extends SessionException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.session.invalid'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
