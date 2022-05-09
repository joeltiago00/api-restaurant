<?php

namespace App\Exceptions\Menu;


use App\Models\Log;
use App\Types\LogTypes;
use Illuminate\Http\Response;

class MenuNotDeleted extends MenuException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.menu.not-deleted', ['error_code' => Log::generate($e, LogTypes::CRITICAL)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
