<?php

namespace Database\Seeders;

use App\Models\Seller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SellerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Seller::create([
            'name' => 'Test Seller',
            'phone' => '01686381990',
            'email' => 'seller@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}