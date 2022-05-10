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
                'first_name' => 'Pedro Paulo',
                'last_name' => 'Alex',
                'document_type' => 'cpf',
                'document_value' => '12345678910',
                'email' => 'pedro.alex@email.com',
                'password' => Hash::make('123123123', ['rounds' => 12]),
                'role_id' => $admin->id,
                'job_function_id' => $waiter->id,
            ],
            [
                'first_name' => 'Conrado',
                'last_name' => 'Aleksandro',
                'document_type' => 'cpf',
                'document_value' => '12345678910',
                'email' => 'conrado.aleksandro@email.com',
                'password' => Hash::make('123123123', ['rounds' => 12]),
                'role_id' => $admin->id,
                'job_function_id' => $waiter->id,
            ],
            [
                'first_name' => 'Henrique',
                'last_name' => 'Juliano',
                'document_type' => 'cpf',
                'document_value' => '12345678910',
                'email' => 'henrique.juliano@email.com',
                'password' => Hash::make('123123123', ['rounds' => 12]),
                'role_id' => $admin->id,
                'job_function_id' => $waiter->id,
            ],
            [
                'first_name' => 'Felipa',
                'last_name' => 'Araujo',
                'document_type' => 'cpf',
                'document_value' => '12345678910',
                'email' => 'felipe.araujo@email.com',
                'password' => Hash::make('123123123', ['rounds' => 12]),
                'role_id' => $admin->id,
                'job_function_id' => $waiter->id,
            ],
            [
                'first_name' => 'Gustavo',
                'last_name' => 'Lima',
                'document_type' => 'cpf',
                'document_value' => '12345678910',
                'email' => 'gustavo.lima@email.com',
                'password' => Hash::make('123123123', ['rounds' => 12]),
                'role_id' => $admin->id,
                'job_function_id' => $waiter->id,
            ],
            [
                'first_name' => 'Jose',
                'last_name' => 'Lutero',
                'document_type' => 'cpf',
                'document_value' => '12345678910',
                'email' => 'jose.lutero@email.com',
                'password' => Hash::make('123123123', ['rounds' => 12]),
                'role_id' => $admin->id,
                'job_function_id' => $cooker->id,
            ],
            [
                'first_name' => 'José Neto',
                'last_name' => 'Cristiano',
                'document_type' => 'cpf',
                'document_value' => '12345678910',
                'email' => 'jose.cristiano@email.com',
                'password' => Hash::make('123123123', ['rounds' => 12]),
                'role_id' => $user->id,
                'job_function_id' => $cooker->id,
            ],
            [
                'first_name' => 'Israel',
                'last_name' => 'Rodolfo',
                'document_type' => 'cpf',
                'document_value' => '12345678910',
                'email' => 'israel.rodolfo@email.com',
                'password' => Hash::make('123123123', ['rounds' => 12]),
                'role_id' => $user->id,
                'job_function_id' => $cooker->id,
            ],
            [
                'first_name' => 'Marcos',
                'last_name' => 'Belutti',
                'document_type' => 'cpf',
                'document_value' => '12345678910',
                'email' => 'marcos.belutti@email.com',
                'password' => Hash::make('123123123', ['rounds' => 12]),
                'role_id' => $user->id,
                'job_function_id' => $cooker->id,
            ],
            [
                'first_name' => 'Lucca',
                'last_name' => 'Mateus',
                'document_type' => 'cpf',
                'document_value' => '12345678910',
                'email' => 'lucca.mateus@email.com',
                'password' => Hash::make('123123123', ['rounds' => 12]),
                'role_id' => $user->id,
                'job_function_id' => $cooker->id,
            ],
        ];

        foreach ($data as $datum) {
            $user =  new User();
            $user->fill($datum)->save();
        }
    }
}
