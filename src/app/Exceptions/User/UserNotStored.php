<?php

namespace App\Exceptions\User;


use App\Models\Log;
use App\Types\LogTypes;
use Illuminate\Http\Response;
use function trans;

class UserNotStored extends UserException
{
    /**
     * @throws \Exception
     */
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exception.user.not-stored', ['error_code' => Log::generate($e, LogTypes::CRITICAL)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
