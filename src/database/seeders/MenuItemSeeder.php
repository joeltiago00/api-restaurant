<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu_1 = Menu::where('name', 'menu1')->first();
        $menu_2 = Menu::where('name', 'menu2')->first();
        $menu_3 = Menu::where('name', 'menu3')->first();

        $data = [
            ['menu_id' => $menu_1->id, 'name' => 'item1', 'price' => 1900.00],
            ['menu_id' => $menu_1->id, 'name' => 'item2', 'price' => 1000.00],
            ['menu_id' => $menu_2->id, 'name' => 'item3', 'price' => 1600.00],
            ['menu_id' => $menu_2->id, 'name' => 'item4', 'price' => 1000.00],
            ['menu_id' => $menu_3->id, 'name' => 'item5', 'price' => 1500.00],
            ['menu_id' => $menu_3->id, 'name' => 'item6', 'price' => 1000.00],
        ];

        foreach ($data as $datum) {
            $item = new MenuItem();
            $item->fill($datum)->save();
        }
    }
}
