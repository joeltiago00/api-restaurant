<?php

namespace App\Exceptions\RequestOrder;


use Illuminate\Http\Response;

class RequestOrderNotCreated extends RequestOrderException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.request-order.not-created'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
