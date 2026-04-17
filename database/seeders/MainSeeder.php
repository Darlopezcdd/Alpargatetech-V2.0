<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Mesa;
use App\Models\Category;
use App\Models\Product;
use App\Enums\UserRole;
use App\Enums\TableStatus;

class MainSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Usuarios ─────────────────────────────────────────────────────────
        User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@alpargatetech.com',
            'password' => Hash::make('Admin123!'),
            'role'     => UserRole::ADMIN,
        ]);

        User::create([
            'name'     => 'Mesero Principal',
            'email'    => 'mesero@alpargatetech.com',
            'password' => Hash::make('Mesero123!'),
            'role'     => UserRole::MESERO,
        ]);

        User::create([
            'name'     => 'Cocinero Jefe',
            'email'    => 'cocina@alpargatetech.com',
            'password' => Hash::make('Cocina123!'),
            'role'     => UserRole::COCINERO,
        ]);

        // ─── Mesas (10 mesas, 4 personas c/u) ────────────────────────────────
        for ($i = 1; $i <= 10; $i++) {
            Mesa::create([
                'number'   => $i,
                'capacity' => 4,
                'status'   => TableStatus::LIBRE,
            ]);
        }

        // ─── Menú: Categorías y Productos ─────────────────────────────────────
        $entradas = Category::create(['name' => 'Entradas']);
        $platos   = Category::create(['name' => 'Platos Fuertes']);
        $postres  = Category::create(['name' => 'Postres']);
        $bebidas  = Category::create(['name' => 'Bebidas']);

        // Entradas
        Product::create(['category_id' => $entradas->id, 'name' => 'Sopa del Día',        'price' => 3.50, 'description' => 'Sopa casera según disponibilidad', 'is_active' => true]);
        Product::create(['category_id' => $entradas->id, 'name' => 'Ensalada César',      'price' => 4.00, 'description' => 'Lechuga romana, crutones, parmesano', 'is_active' => true]);
        Product::create(['category_id' => $entradas->id, 'name' => 'Patacones con Queso', 'price' => 3.00, 'description' => 'Patacones fritos con queso derretido', 'is_active' => true]);

        // Platos Fuertes
        Product::create(['category_id' => $platos->id, 'name' => 'Hamburguesa Especial', 'price' => 7.50, 'description' => 'Doble carne, queso, lechuga, tomate', 'is_active' => true]);
        Product::create(['category_id' => $platos->id, 'name' => 'Pollo a la Plancha',   'price' => 8.00, 'description' => 'Con arroz, ensalada y papas fritas',  'is_active' => true]);
        Product::create(['category_id' => $platos->id, 'name' => 'Arroz con Mariscos',   'price' => 12.00,'description' => 'Arroz con camarones, concha y calamar', 'is_active' => true]);
        Product::create(['category_id' => $platos->id, 'name' => 'Lomo Saltado',         'price' => 10.00,'description' => 'Carne salteada con verduras y arroz', 'is_active' => true]);
        Product::create(['category_id' => $platos->id, 'name' => 'Papas Fritas (porción)','price' => 2.50, 'description' => 'Porción grande de papas fritas',      'is_active' => true]);

        // Postres
        Product::create(['category_id' => $postres->id, 'name' => 'Flan Casero',         'price' => 3.00, 'description' => 'Flan de vainilla con caramelo',       'is_active' => true]);
        Product::create(['category_id' => $postres->id, 'name' => 'Helado 3 Bolas',      'price' => 2.50, 'description' => 'Vainilla, chocolate y fresa',         'is_active' => true]);
        Product::create(['category_id' => $postres->id, 'name' => 'Torta de Chocolate',  'price' => 4.00, 'description' => 'Porción de torta húmeda de chocolate', 'is_active' => true]);

        // Bebidas
        Product::create(['category_id' => $bebidas->id, 'name' => 'Coca Cola',           'price' => 1.50, 'description' => 'Lata 355ml',                          'is_active' => true]);
        Product::create(['category_id' => $bebidas->id, 'name' => 'Agua sin Gas',        'price' => 0.75, 'description' => 'Botella 500ml',                       'is_active' => true]);
        Product::create(['category_id' => $bebidas->id, 'name' => 'Jugo Natural',        'price' => 2.00, 'description' => 'Naranja, mora o maracuyá (temporada)','is_active' => true]);
        Product::create(['category_id' => $bebidas->id, 'name' => 'Café Americano',      'price' => 1.50, 'description' => 'Café negro en taza grande',            'is_active' => true]);
        Product::create(['category_id' => $bebidas->id, 'name' => 'Limonada Natural',    'price' => 2.50, 'description' => 'Limonada fresca con menta',            'is_active' => true]);
    }
}
