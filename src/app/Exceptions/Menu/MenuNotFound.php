<?php

namespace App\Exceptions\Menu;


use Illuminate\Http\Response;

class MenuNotFound extends MenuException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.menu.not-found'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
