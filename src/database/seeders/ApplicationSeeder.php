<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\RequestOrder;
use App\Models\RequestOrderItem;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('pt_BR');

        for ($i = 0; $i <= 10000; $i++) {
            Customer::create([
                'first_name' => $faker->name,
                'last_name' => $faker->name,
                'document_type' => 'cpf',
                'document_value' => '57677516092',
                'email' => $faker->unique()->safeEmail
            ]);
        }

        for ($i = 0; $i <= 50; $i++) {
            $menu = Menu::create([
                'name' => $faker->name
            ]);

            for ($i = 0; $i <= 10; $i++) {
                MenuItem::create([
                    'menu_id' => $menu->id,
                    'name' => $faker->name,
                    'price' => $faker->randomFloat(2, 0, 400000)
                ]);
            }
        }

        for ($i = 0; $i <= 200000; $i++) {
            $order = RequestOrder::create([
                'customer_id' => $faker->numberBetween(1, 10000),
                'waiter_id' => $faker->numberBetween(1, 5),
                'cooker_id' => $faker->numberBetween(6, 10),
                'table_id' => $faker->numberBetween(1, 5),
                'status' => 'finished',
                'price' => $faker->randomFloat(2, 100000, 400000),
                'finished_at' => $faker->dateTimeThisMonth(),
                'started_at' => $faker->dateTimeThisMonth(),
            ]);

            for ($i = 0; $i <= 5; $i++) {
                RequestOrderItem::create([
                    'request_order_id' => $order->id,
                    'menu_id' => $faker->numberBetween(1, 50),
                    'item_id' => $faker->numberBetween(1, 10)
                ]);
            }
        }

        for ($i = 0; $i <= 100000; $i++) {
            $order = RequestOrder::create([
                'customer_id' => $faker->numberBetween(1, 10000),
                'waiter_id' => $faker->numberBetween(1, 5),
                'cooker_id' => $faker->numberBetween(6, 10),
                'table_id' => $faker->numberBetween(1, 6),
                'status' => 'pending',
                'price' => $faker->randomFloat(2, 100000, 400000),
            ]);

            for ($i = 0; $i <= 5; $i++) {
                RequestOrderItem::create([
                    'request_order_id' => $order->id,
                    'menu_id' => $faker->numberBetween(1, 50),
                    'item_id' => $faker->numberBetween(1, 10)
                ]);
            }
        }

        for ($i = 0; $i <= 50000; $i++) {
            $order = RequestOrder::create([
                'customer_id' => $faker->numberBetween(1, 10000),
                'waiter_id' => $faker->numberBetween(1, 5),
                'cooker_id' => $faker->numberBetween(6, 10),
                'table_id' => $faker->numberBetween(1, 5),
                'status' => 'preparing',
                'price' => $faker->randomFloat(2, 100000, 400000),
                'started_at' => $faker->dateTimeThisMonth(),
            ]);

            for ($i = 0; $i <= 5; $i++) {
                RequestOrderItem::create([
                    'request_order_id' => $order->id,
                    'menu_id' => $faker->numberBetween(1, 50),
                    'item_id' => $faker->numberBetween(1, 10)
                ]);
            }
        }

        for ($i = 0; $i <= 50000; $i++) {
            $order = RequestOrder::create([
                'customer_id' => $faker->numberBetween(1, 10000),
                'waiter_id' => $faker->numberBetween(1, 5),
                'cooker_id' => $faker->numberBetween(6, 10),
                'table_id' => $faker->numberBetween(1, 5),
                'status' => 'pending',
                'price' => $faker->randomFloat(2, 100000, 400000),
            ]);

            for ($i = 0; $i <= 5; $i++) {
                RequestOrderItem::create([
                    'request_order_id' => $order->id,
                    'menu_id' => $faker->numberBetween(1, 50),
                    'item_id' => $faker->numberBetween(1, 10)
                ]);
            }
        }
    }
}
