<?php

namespace App\Exceptions\Session;


use App\Models\Log;
use App\Types\LogTypes;
use Illuminate\Http\Response;

class SessionNotStored extends SessionException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.session.not-stored', ['error_code' => Log::generate($e, LogTypes::CRITICAL)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
