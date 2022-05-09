<?php

namespace App\Exceptions\Menu;


use Illuminate\Http\Response;

class MenuNotGeted extends MenuException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.menu.not-geted'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
