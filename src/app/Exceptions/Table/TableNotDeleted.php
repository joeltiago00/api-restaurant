<?php

namespace App\Exceptions\Table;


use App\Models\Log;
use App\Types\LogTypes;
use Illuminate\Http\Response;

class TableNotDeleted extends TableException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.table.not-deleted', ['error_code' => Log::generate($e, LogTypes::CRITICAL)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
