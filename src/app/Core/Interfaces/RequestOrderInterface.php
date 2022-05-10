<?php

namespace App\Core\Interfaces;

interface RequestOrderInterface
{
    public function getCustomerId(): int;

    public function getWaiterId(): int;

    public function getStatus(): string;

    public function getTableId(): int;
}
