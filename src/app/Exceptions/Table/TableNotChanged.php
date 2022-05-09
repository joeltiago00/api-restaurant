<?php

namespace App\Exceptions\Table;


use Illuminate\Http\Response;

class TableNotChanged extends TableException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.table.not-changed'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
