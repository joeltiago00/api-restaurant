<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\RequestOrder;
use App\Models\RequestOrderItem;
use App\Types\RequestOrderStatusTypes;
use Illuminate\Database\Seeder;

class RequestOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            ['table_id' => 1, 'customer_id' => 1, 'waiter_id' => 3, 'cooker_id' => 2, 'price' => 14000, 'status' => RequestOrderStatusTypes::PENDING],
            ['table_id' => 6, 'customer_id' => 1, 'waiter_id' => 3, 'cooker_id' => 1, 'price' => 15000, 'status' => RequestOrderStatusTypes::PENDING],
            ['table_id' => 2, 'customer_id' => 2, 'waiter_id' => 4, 'cooker_id' => 2, 'price' => 16000, 'status' => RequestOrderStatusTypes::PENDING],
            ['table_id' => 1, 'customer_id' => 2, 'waiter_id' => 3, 'cooker_id' => 1, 'price' => 20000, 'status' => RequestOrderStatusTypes::PENDING],
            ['table_id' => 4, 'customer_id' => 2, 'waiter_id' => 4, 'cooker_id' => 2, 'price' => 1000, 'status' => RequestOrderStatusTypes::PENDING],
            ['table_id' => 5, 'customer_id' => 3, 'waiter_id' => 3, 'cooker_id' => 1, 'price' => 12000, 'status' => RequestOrderStatusTypes::PENDING],
        ];

        foreach ($data as $datum) {
            $order = new RequestOrder();
            $order->fill($datum)->save();
        }

        $data = [
            ['request_order_id' => 1, 'menu_id' => 1, 'item_id' => 1],
            ['request_order_id' => 1, 'menu_id' => 3, 'item_id' => 2],
            ['request_order_id' => 1, 'menu_id' => 1, 'item_id' => 1],
            ['request_order_id' => 2, 'menu_id' => 1, 'item_id' => 1],
            ['request_order_id' => 2, 'menu_id' => 2, 'item_id' => 2],
            ['request_order_id' => 2, 'menu_id' => 3, 'item_id' => 2],
            ['request_order_id' => 3, 'menu_id' => 1, 'item_id' => 1],
            ['request_order_id' => 4, 'menu_id' => 3, 'item_id' => 2],
            ['request_order_id' => 3, 'menu_id' => 3, 'item_id' => 2],
            ['request_order_id' => 3, 'menu_id' => 3, 'item_id' => 2],
        ];

        foreach ($data as $datum) {
            $order_item = new RequestOrderItem();
            $order_item->fill($datum)->save();
        }
    }
}
