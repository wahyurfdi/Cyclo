<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::insert([
            'name' => 'Why You',
            'phone' => '6282128415485',
            'address' => 'Jl. Rancabentang Barat',
            'username' => 'whyyou',
            'password' => bcrypt('whyyou'),
            'coin' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
