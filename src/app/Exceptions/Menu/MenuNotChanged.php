<?php

namespace App\Exceptions\Menu;


use Illuminate\Http\Response;

class MenuNotChanged extends MenuException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.menu.not-changed'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
