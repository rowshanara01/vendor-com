<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Test Admin',
            'phone' => '01686381991',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}