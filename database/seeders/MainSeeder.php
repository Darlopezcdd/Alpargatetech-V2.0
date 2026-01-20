<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Usuarios
        \App\Models\User::create([
            'name' => 'Administrador',
            'email' => 'admin@alpargatetech.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => \App\Enums\UserRole::ADMIN
        ]);

        \App\Models\User::create([
            'name' => 'Mesero 1',
            'email' => 'mesero@alpargatetech.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => \App\Enums\UserRole::MESERO
        ]);

        \App\Models\User::create([
            'name' => 'Cocinero Jefe',
            'email' => 'cocina@alpargatetech.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => \App\Enums\UserRole::COCINERO
        ]);

        // 2. Mesas
        for ($i = 1; $i <= 10; $i++) {
            \App\Models\Mesa::create([
                'number' => $i,
                'capacity' => 4,
                'status' => \App\Enums\TableStatus::LIBRE
            ]);
        }

        // 3. Categorías y Productos
        $catBebidas = \App\Models\Category::create(['name' => 'Bebidas']);
        $catPlatos = \App\Models\Category::create(['name' => 'Platos Fuertes']);

        \App\Models\Product::create([
            'category_id' => $catBebidas->id,
            'name' => 'Coca Cola',
            'price' => 1.50,
            'description' => 'Refresco de 500ml',
            'stock' => 100
        ]);

        \App\Models\Product::create([
            'category_id' => $catPlatos->id,
            'name' => 'Hamburguesa Especial',
            'price' => 5.00,
            'description' => 'Con doble carne y queso',
            'stock' => 50
        ]);

        \App\Models\Product::create([
            'category_id' => $catPlatos->id,
            'name' => 'Papas Fritas',
            'price' => 2.50,
            'description' => 'Porción grande',
            'stock' => 50
        ]);
    }
}
