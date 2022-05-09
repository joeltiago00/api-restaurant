<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['number' => 1, 'quantity_seats' => 4],
            ['number' => 2, 'quantity_seats' => 4],
            ['number' => 3, 'quantity_seats' => 8],
            ['number' => 4, 'quantity_seats' => 8],
            ['number' => 5, 'quantity_seats' => 2],
            ['number' => 6, 'quantity_seats' => 2],
        ];

        foreach ($data as $datum) {
            $table = new Table();
            $table->fill($datum)->save();
        }
    }
}
