<?php

namespace App\Exceptions\RequestOrder;


use Illuminate\Http\Response;

class RequestOrderNotExcluded extends RequestOrderException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.request-user.not-excluded'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
