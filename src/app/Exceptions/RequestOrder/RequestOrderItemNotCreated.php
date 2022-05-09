<?php

namespace App\Exceptions\RequestOrder;


use Illuminate\Http\Response;

class RequestOrderItemNotCreated extends RequestOrderException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.request-order.item.not-created'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
