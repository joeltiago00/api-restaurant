<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'first_name' => 'Joel Tiago',
                'last_name' => 'Almeida',
                'document_type' => 'cpf',
                'document_value' => '12345678910',
                'email' => 'joel.tiago@email.com',
            ],
            [
                'first_name' => 'Joel Tiago',
                'last_name' => 'Almeida',
                'document_type' => 'cpf',
                'document_value' => '12345678910',
                'email' => 'joel.tiago2@email.com',
            ],
            [
                'first_name' => 'Joel Tiago',
                'last_name' => 'Almeida',
                'document_type' => 'cpf',
                'document_value' => '12345678910',
                'email' => 'joel.tiago3@email.com',
            ],
            [
                'first_name' => 'Joel Tiago',
                'last_name' => 'Almeida',
                'document_type' => 'cpf',
                'document_value' => '12345678910',
                'email' => 'joel.tiago4@email.com',
            ],
        ];

        foreach ($data as $datum) {
            $user =  new Customer();
            $user->fill($datum)->save();
        }
    }
}
