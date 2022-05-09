<?php

namespace App\Exceptions\Costumer;

use App\Models\Log;
use App\Types\LogTypes;
use Illuminate\Http\Response;

class CostumerNotStored extends CostumerException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.costumer.not-stored', ['error_code' => Log::generate($e, LogTypes::CRITICAL)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
