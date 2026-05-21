<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\models\Productos;
use Database\Factories\ProductosFactory;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Productos::factory(10)->create();
        /*$productos = [
            'name' => 'Laptop HP',
            'description' => 'Laptop HP Probook',
            'price' => 1000,
            'stock' => 10,
            'is_active' => true,
        ];*/
       // Productos::create($productos);
    }
}
