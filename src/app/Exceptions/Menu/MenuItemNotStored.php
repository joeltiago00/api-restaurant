<?php

namespace App\Exceptions\Menu;


use App\Models\Log;
use App\Types\LogTypes;
use Illuminate\Http\Response;

class MenuItemNotStored extends MenuException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.menu.item.not-stored', ['error_code' => Log::generate($e, LogTypes::CRITICAL)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
