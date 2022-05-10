<?php

namespace App\Exceptions\Custumer;


use Illuminate\Http\Response;

class InvalidCustomer extends CustumerException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.customer.invalid'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
