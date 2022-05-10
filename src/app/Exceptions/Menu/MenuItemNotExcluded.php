<?php

namespace App\Exceptions\Menu;


use Illuminate\Http\Response;

class MenuItemNotExcluded extends MenuException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.menu.item.not-excluded'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
