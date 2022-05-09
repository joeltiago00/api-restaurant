<?php

namespace App\Exceptions\Table;


use Illuminate\Http\Response;

class TableNotFound extends TableException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.table.not-found'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
