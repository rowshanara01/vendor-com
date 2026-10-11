<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\District;
use App\Models\Division;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Admin::truncate();
        Seller::truncate();
        Division::truncate();
        District::truncate();
        User::truncate();

        $this->call([
            AdminTableSeeder::class,
            SellerTableSeeder::class,
            DivisionSeeder::class,
            DistrictSeeder::class,
        ]);

        \App\Models\User::factory(10)->create();
        \App\Models\Seller::factory(50)->create();
        \App\Models\Brand::factory(20)->create();
        \App\Models\Slider::factory(8)->create();
        \App\Models\Category::factory(30)->create();
        \App\Models\SubCategory::factory(100)->create();
        \App\Models\Product::factory(100)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'phone' => '01686381998',
            'email' => 'test@example.com',
            "isVerified" => 1,
            'password' => Hash::make('password'),
        ]);



    }
}