<?php

namespace App\Core\Interfaces;

interface MenuItemInterface
{
    public function getId(): int;

    public function getMenuId(): int;

    public function getName(): string;

    public function getPrice():float;
}
