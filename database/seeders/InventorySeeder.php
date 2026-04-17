<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredient;
use App\Models\FixedAsset;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        // ─── Ingredientes básicos de un restaurante ──────────────────────────
        $ingredients = [
            ['name' => 'Pollo',              'unit' => 'kg',     'stock_actual' => 15.00, 'stock_minimo' => 5.00],
            ['name' => 'Carne de res',       'unit' => 'kg',     'stock_actual' => 10.00, 'stock_minimo' => 4.00],
            ['name' => 'Arroz',              'unit' => 'kg',     'stock_actual' => 25.00, 'stock_minimo' => 10.00],
            ['name' => 'Papa',               'unit' => 'kg',     'stock_actual' => 20.00, 'stock_minimo' => 8.00],
            ['name' => 'Tomate',             'unit' => 'kg',     'stock_actual' => 8.00,  'stock_minimo' => 3.00],
            ['name' => 'Cebolla',            'unit' => 'kg',     'stock_actual' => 6.00,  'stock_minimo' => 2.00],
            ['name' => 'Aceite de oliva',    'unit' => 'L',      'stock_actual' => 4.00,  'stock_minimo' => 1.00],
            ['name' => 'Sal',                'unit' => 'kg',     'stock_actual' => 3.00,  'stock_minimo' => 1.00],
            ['name' => 'Queso mozzarella',   'unit' => 'kg',     'stock_actual' => 2.50,  'stock_minimo' => 1.00],
            ['name' => 'Pan de hamburguesa', 'unit' => 'unidad', 'stock_actual' => 60.00, 'stock_minimo' => 20.00],
            ['name' => 'Lechuga',            'unit' => 'unidad', 'stock_actual' => 10.00, 'stock_minimo' => 4.00],
            ['name' => 'Azúcar',             'unit' => 'kg',     'stock_actual' => 5.00,  'stock_minimo' => 2.00],
            // Stock bajo intencionalmente para demo de alertas
            ['name' => 'Pimienta negra',     'unit' => 'kg',     'stock_actual' => 0.20,  'stock_minimo' => 0.50],
            ['name' => 'Limón',              'unit' => 'unidad', 'stock_actual' => 5.00,  'stock_minimo' => 10.00],
        ];

        foreach ($ingredients as $ing) {
            Ingredient::create($ing);
        }

        // ─── Activos fijos del restaurante ───────────────────────────────────
        $assets = [
            ['name' => 'Mesa de 4 puestos',      'description' => 'Mesas principales del salón',         'quantity' => 10, 'status' => 'Operativo'],
            ['name' => 'Silla estándar',          'description' => 'Sillas de madera con cojín',          'quantity' => 40, 'status' => 'Operativo'],
            ['name' => 'Horno industrial',        'description' => 'Horno de gas 4 quemadores',           'quantity' => 2,  'status' => 'Operativo'],
            ['name' => 'Refrigerador comercial',  'description' => 'Refrigerador doble puerta 400L',      'quantity' => 1,  'status' => 'Operativo'],
            ['name' => 'Freidora industrial',     'description' => 'Freidora eléctrica 8L',               'quantity' => 1,  'status' => 'Operativo'],
            ['name' => 'Licuadora industrial',    'description' => 'Licuadora 3L de alta potencia',       'quantity' => 2,  'status' => 'Operativo'],
            ['name' => 'Caja registradora',       'description' => 'Terminal POS con impresora',          'quantity' => 1,  'status' => 'Operativo'],
            ['name' => 'Microondas',              'description' => 'Microondas 1200W',                    'quantity' => 1,  'status' => 'En reparación'],
            ['name' => 'Campana extractora',      'description' => 'Sistema de ventilación cocina',       'quantity' => 1,  'status' => 'Operativo'],
            ['name' => 'Lava platos industrial',  'description' => 'Lava platos de acero inoxidable',     'quantity' => 1,  'status' => 'Operativo'],
            ['name' => 'TV pantalla 55"',         'description' => 'Smart TV para entretenimiento clientes', 'quantity' => 2, 'status' => 'Operativo'],
            ['name' => 'Silla alta bebe',         'description' => 'Sillas altas para bebes',             'quantity' => 3,  'status' => 'Operativo'],
        ];

        foreach ($assets as $asset) {
            FixedAsset::create($asset);
        }
    }
}
