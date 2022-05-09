<?php

namespace App\Exceptions\Table;


use Illuminate\Http\Response;

class TableNotDeleted extends TableException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.table.not-deleted'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
