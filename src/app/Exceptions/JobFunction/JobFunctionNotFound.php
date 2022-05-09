<?php

namespace App\Exceptions\JobFunction;


use Illuminate\Http\Response;

class JobFunctionNotFound extends JobFunctionException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.job-function.not-found'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
