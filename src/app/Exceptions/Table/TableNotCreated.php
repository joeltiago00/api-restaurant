<?php

namespace App\Exceptions\Table;


use Illuminate\Http\Response;

class TableNotCreated extends TableException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.table.not-created'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
