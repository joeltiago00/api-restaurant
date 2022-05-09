<?php

namespace App\Exceptions\Table;


use App\Models\Log;
use App\Types\LogTypes;
use Illuminate\Http\Response;

class TableNotUpdated extends TableException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.table.not-updated', ['error_code' => Log::generate($e, LogTypes::CRITICAL)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
