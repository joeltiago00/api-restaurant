<?php

namespace App\Exceptions\RequestOrder;

use Illuminate\Http\Response;

class RequestOrderNotStarted extends RequestOrderException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.request-order.not-started'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
