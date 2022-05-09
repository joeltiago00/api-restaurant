<?php

namespace App\Core\Interfaces\RequestOrder;

interface RequestOrderItemInterface
{
    public function getRequestOrderId(): int;

    public function getMenuId(): int;

    public function getMenuItemId(): int;
}
