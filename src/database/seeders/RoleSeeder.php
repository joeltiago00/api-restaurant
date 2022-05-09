<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Types\RoleTypes;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => RoleTypes::USER],
            ['name' => RoleTypes::ADMIN]
        ];

        foreach ($data as $datum) {
            $role = new Role();
            $role->fill($datum)->save();
        }
    }
}
