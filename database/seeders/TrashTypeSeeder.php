<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrashType;

class TrashTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TrashType::insert([
            [
                'id' => 1,
                'name' => 'Plastik',
                'description' => 'Sampah berbahan plastik',
                'image' => 'trash-01.jpg',
                'coin_per_qty' => 10,
                'weight_per_qty' => 0.5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'name' => 'Kertas',
                'description' => 'Sampah berbahan kertas',
                'image' => 'trash-02.jpg',
                'coin_per_qty' => 5,
                'weight_per_qty' => 0.1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'name' => 'Kaleng',
                'description' => 'Sampah berbahan kaleng',
                'image' => 'trash-03.jpg',
                'coin_per_qty' => 25,
                'weight_per_qty' => 0.5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 4,
                'name' => 'Kaca',
                'description' => 'Sampah berbahan kaca',
                'image' => 'trash-04.jpg',
                'coin_per_qty' => 50,
                'weight_per_qty' => 0.8,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
