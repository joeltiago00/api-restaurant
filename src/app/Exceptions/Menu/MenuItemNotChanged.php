<?php

namespace App\Exceptions\Menu;


use Illuminate\Http\Response;

class MenuItemNotChanged extends MenuException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.menu.item.not-changed'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
