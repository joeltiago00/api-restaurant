<?php

namespace App\Core\Interfaces\RequestOrder;

use Carbon\Carbon;

interface RequestOrderInterface
{
    public function getWaiterId(): int;

    public function getStatus(): string;

    public function getTableId(): int;
}
