<?php

namespace Database\Seeders;

use App\Models\JobFunction;
use App\Types\JobFunctionTypes;
use Illuminate\Database\Seeder;

class JobFunctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => JobFunctionTypes::COOKER],
            ['name' => JobFunctionTypes::WAITER]
        ];

        foreach ($data as $datum) {
            $job_function = new JobFunction();
            $job_function->fill($datum)->save();
        }
    }
}
