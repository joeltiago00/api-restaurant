<?php

namespace Database\Seeders;

use App\Models\JobFunction;
use App\Models\Role;
use App\Models\User;
use App\Types\JobFunctionTypes;
use App\Types\RoleTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::where('name', RoleTypes::ADMIN)->first();
        $user = Role::where('name', RoleTypes::USER)->first();

        $cooker = JobFunction::where('name', JobFunctionTypes::COOKER)->first();
        $waiter = JobFunction::where('name', JobFunctionTypes::WAITER)->first();

        $data = [
            [
                'first_name' => 'Joel Tiago',
                'last_name' => 'Almeida',
                'document_type' => 'cpf',
                'document_value' => '12345678910',
                'email' => 'joel.tiago@email.com',
                'password' => Hash::make('123123123', ['rounds' => 12]),
                'role_id' => $admin->id,
                'job_function_id' => $cooker->id,
            ],
            [
                'first_name' => 'Joel Tiago',
                'last_name' => 'Almeida',
                'document_type' => 'cpf',
                'document_value' => '12345678910',
                'email' => 'joel.tiago2@email.com',
                'password' => Hash::make('123123123', ['rounds' => 12]),
                'role_id' => $user->id,
                'job_function_id' => $cooker->id,
            ],
            [
                'first_name' => 'Joel Tiago',
                'last_name' => 'Almeida',
                'document_type' => 'cpf',
                'document_value' => '12345678910',
                'email' => 'joel.tiago3@email.com',
                'password' => Hash::make('123123123', ['rounds' => 12]),
                'role_id' => $admin->id,
                'job_function_id' => $waiter->id,
            ],
            [
                'first_name' => 'Joel Tiago',
                'last_name' => 'Almeida',
                'document_type' => 'cpf',
                'document_value' => '12345678910',
                'email' => 'joel.tiago4@email.com',
                'password' => Hash::make('123123123', ['rounds' => 12]),
                'role_id' => $admin->id,
                'job_function_id' => $waiter->id,
            ],
        ];

        foreach ($data as $datum) {
            $user =  new User();
            $user->fill($datum)->save();
        }
    }
}
