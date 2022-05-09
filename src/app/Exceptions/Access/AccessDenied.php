<?php

namespace App\Exceptions\Access;


use Illuminate\Http\Response;

class AccessDenied extends AccessExceptions
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.access.denied'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
