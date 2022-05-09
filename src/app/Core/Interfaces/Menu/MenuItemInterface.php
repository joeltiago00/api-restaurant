<?php

namespace App\Core\Interfaces\Menu;

interface MenuItemInterface
{
    public function getId(): int;

    public function getMenuId(): int;

    public function getName(): string;

    public function getPrice():float;
}
