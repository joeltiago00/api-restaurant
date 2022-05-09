<?php

namespace App\Exceptions\Menu;


use Illuminate\Http\Response;

class MenuNotCreated extends MenuException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.menu.not-created'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
