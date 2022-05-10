<?php

namespace App\Exceptions\RequestOrder;


use Illuminate\Http\Response;

class RequestOrderNotChanged extends RequestOrderException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.request-order.not-changed'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
