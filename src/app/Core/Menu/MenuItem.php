<?php

namespace App\Core\Menu;

use App\Core\Interfaces\MenuInterface;
use App\Core\Interfaces\MenuItemInterface;

class MenuItem implements MenuItemInterface
{
    /**
     * @var int|null
     */
    private ?int $id;
    /**
     * @var MenuInterface
     */
    private MenuInterface $menu;
    /**
     * @var string
     */
    private string $name;
    /**
     * @var float
     */
    private float $price;

    /**
     * @param MenuInterface $menu
     * @param string $name
     * @param float $price
     * @param int|null $id
     */
    public function __construct(MenuInterface $menu, string $name, float $price, int $id = null)
    {
        $this->menu = $menu;
        $this->name = $name;
        $this->price = $price;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getMenuId(): int
    {
        return $this->menu->getId();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
