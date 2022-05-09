<?php

namespace App\Exceptions\RequestOrder;


use Illuminate\Http\Response;

class RequestOrderPriceNotSeted extends RequestOrderException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.request-order.price-not-seted'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
