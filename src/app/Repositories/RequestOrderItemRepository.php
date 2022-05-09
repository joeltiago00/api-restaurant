<?php

namespace App\Repositories;

use App\Exceptions\Menu\{
    MenuItemNotFound,
    MenuNotFound,
};
use App\Exceptions\RequestOrder\{
    RequestOrderItemNotCreated,
    RequestOrderItemNotStored,
    RequestOrderPriceNotSeted
};
use App\Models\{
    RequestOrder,
    RequestOrderItem,
};

class RequestOrderItemRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(RequestOrderItem::class);
    }

    /**
     * @param RequestOrder $order
     * @param array $item
     * @return float
     * @throws MenuItemNotFound
     * @throws MenuNotFound
     * @throws RequestOrderItemNotStored
     */
    private function store(RequestOrder $order, array $item): float
    {
        if (!(new MenuRepository())->existsById($item['menu_id']))
            throw new MenuNotFound();

        if (!(new MenuItemRepository())->existsById($item['item_id']))
            throw new MenuItemNotFound();

        try {
            if (!$request_order_item = $order->requestOderItem()->create([
                'menu_id' => $item['menu_id'],
                'item_id' => $item['item_id']
            ]))
                throw new RequestOrderItemNotCreated();
        } catch (\Exception $e) {
            throw new RequestOrderItemNotStored($e);
        }

        if (!$item = $request_order_item->item()->first())
            throw new MenuItemNotFound();

        return $item->price;
    }

    /**
     * @param RequestOrder $order
     * @param array $items
     * @return void
     * @throws RequestOrderItemNotStored
     */
    public function storeItems(RequestOrder $order, array $items): void
    {
        $price = 0;

        try {
            foreach ($items as $item) {
                if (!$price += $this->store($order, $item))
                    throw new RequestOrderItemNotCreated();
            }

            if (!(new RequestOrderRepository())->setPrice($order, $price))
                throw new RequestOrderPriceNotSeted();
        } catch (\Exception $e) {
            throw new RequestOrderItemNotStored($e);
        }
    }
}
