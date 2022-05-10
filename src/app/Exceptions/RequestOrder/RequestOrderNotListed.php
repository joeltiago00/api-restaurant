<?php

namespace App\Exceptions\RequestOrder;


use Illuminate\Http\Response;

class RequestOrderNotListed extends RequestOrderException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.request-order.not-listed'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
