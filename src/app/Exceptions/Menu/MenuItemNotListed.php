<?php

namespace App\Exceptions\Menu;


use Illuminate\Http\Response;

class MenuItemNotListed extends MenuException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.menu.item.not-listed'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
