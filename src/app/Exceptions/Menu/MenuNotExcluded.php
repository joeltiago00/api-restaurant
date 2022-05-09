<?php

namespace App\Exceptions\Menu;


use Illuminate\Http\Response;

class MenuNotExcluded extends MenuException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.menu.not-excluded'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
