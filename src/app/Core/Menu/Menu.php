<?php

namespace App\Core\Menu;

use App\Core\Interfaces\Menu\MenuInterface;

class Menu implements MenuInterface
{
    /**
     * @var int
     */
    private int $id;
    /**
     * @var string
     */
    private string $name;

    /**
     * @param int|null $id
     * @param string|null $name
     */
    public function __construct(int $id = null, string $name = null)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
