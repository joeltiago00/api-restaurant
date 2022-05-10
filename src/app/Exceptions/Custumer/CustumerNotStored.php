<?php

namespace App\Exceptions\Custumer;

use App\Models\Log;
use App\Types\LogTypes;
use Illuminate\Http\Response;

class CustumerNotStored extends CustumerException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.custumer.not-stored', ['error_code' => Log::generate($e, LogTypes::CRITICAL)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
