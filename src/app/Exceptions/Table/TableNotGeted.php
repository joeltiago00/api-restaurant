<?php

namespace App\Exceptions\Table;


use Illuminate\Http\Response;

class TableNotGeted extends TableException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.table.not-geted'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
