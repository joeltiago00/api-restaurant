<?php

namespace App\Core\Interfaces;

interface RequestOrderItemInterface
{
    public function getRequestOrderId(): int;

    public function getMenuId(): int;

    public function getMenuItemId(): int;
}
