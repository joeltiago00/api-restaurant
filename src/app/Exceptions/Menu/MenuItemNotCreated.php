<?php

namespace App\Exceptions\Menu;


use Illuminate\Http\Response;

class MenuItemNotCreated extends MenuException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.menu.item.not-created'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
