<?php

namespace App\Core\Interfaces;

interface RequestOrderInterface
{
    public function getWaiterId(): int;

    public function getStatus(): string;

    public function getTableId(): int;
}
