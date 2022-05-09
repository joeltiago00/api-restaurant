<?php

namespace App\Exceptions\RequestOrder;

use Illuminate\Http\Response;

class RequestOrderCookerNotSeted extends RequestOrderException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.request-order.cooker-not-seted'),
            Response::HTTP_UNPROCESSABLE_ENTITY
            );
    }
}
