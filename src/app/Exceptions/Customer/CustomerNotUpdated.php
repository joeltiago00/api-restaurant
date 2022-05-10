<?php

namespace App\Exceptions\Customer;

use App\Exceptions\Custumer\CustumerException;
use App\Models\Log;
use App\Types\LogTypes;
use Illuminate\Http\Response;

class CustomerNotUpdated extends CustumerException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.user.not-updated', ['error_code' => Log::generate($e, LogTypes::CRITICAL)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
