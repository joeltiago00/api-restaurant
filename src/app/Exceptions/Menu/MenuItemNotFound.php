<?php

namespace App\Exceptions\Menu;


use Illuminate\Http\Response;

class MenuItemNotFound extends MenuException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.menu.item.not-found'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
