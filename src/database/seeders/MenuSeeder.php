<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'menu1'],
            ['name' => 'menu2'],
            ['name' => 'menu3'],
        ];

        foreach ($data as$datum) {
            $menu = new Menu();
            $menu->fill($datum)->save();
        }
    }
}
