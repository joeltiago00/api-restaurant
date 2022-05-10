<?php

namespace App\Exceptions\Menu;


use Illuminate\Http\Response;

class MenuNotListed extends MenuException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.menu.not-listed'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
