<?php

namespace App\Exceptions\RequestOrder;


use App\Models\Log;
use App\Types\LogTypes;
use Illuminate\Http\Response;

class RequestOrderPriceNotUpdated extends RequestOrderException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.request-order.price-not-updated', ['error_code' => Log::generate($e, LogTypes::CRITICAL)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
