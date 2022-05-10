<?php

namespace App\Exceptions\Customer;

use App\Exceptions\Custumer\CustumerException;
use Illuminate\Http\Response;

class CustomerNotExcluded extends CustumerException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.customer.not-excluded'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
