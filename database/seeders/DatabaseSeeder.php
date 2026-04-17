<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Mesa;
use App\Models\Category;
use App\Models\Product;
use App\Models\Ingredient;
use App\Models\FixedAsset;
use App\Enums\UserRole;
use App\Enums\TableStatus;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(MainSeeder::class);
        $this->call(InventorySeeder::class);
    }
}
