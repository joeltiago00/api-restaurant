<?php

namespace App\Exceptions\RequestOrder;


use Illuminate\Http\Response;

class RequestOrderNotFinished extends RequestOrderException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.request-order.not-finished'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
