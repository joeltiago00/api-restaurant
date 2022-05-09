<?php

namespace App\Exceptions\General;


use Illuminate\Http\Response;

class NothingToUpdate extends GeneralException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.general.nothing-to-update'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
