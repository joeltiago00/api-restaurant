<?php

namespace App\Exceptions\User;


use App\Models\Log;
use App\Types\LogTypes;
use Illuminate\Http\Response;

class UserNotDeleted extends UserException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.user.not-deleted', ['error_code' => Log::generate($e, LogTypes::CRITICAL)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
