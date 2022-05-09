<?php

namespace App\Exceptions\Table;


use Illuminate\Http\Response;

class TableNotExcluded extends TableException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.table.not-excluded'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
