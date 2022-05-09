<?php

namespace App\Core\RequestOrder;

use App\Core\Interfaces\RequestOrderItemInterface;

class RequestOrderItem implements RequestOrderItemInterface
{
    /**
     * @var int
     */
    private int $requestOrderId;
    /**
     * @var int
     */
    private int $menuId;
    /**
     * @var int
     */
    private int $menuItemId;

    /**
     * @param int $requestOrderId
     * @param int $menu
     * @param int $menuItem
     */
    public function __construct(int $requestOrderId, int $menu, int $menuItem)
    {
        $this->requestOrderId = $requestOrderId;
        $this->menuId = $menu;
        $this->menuItemId = $menuItem;
    }

    /**
     * @return int
     */
    public function getRequestOrderId(): int
    {
        return $this->requestOrderId;
    }

    /**
     * @return int
     */
    public function getMenuId(): int
    {
        return $this->menuId;
    }

    /**
     * @return int
     */
    public function getMenuItemId(): int
    {
        return $this->menuItemId;
    }
}
