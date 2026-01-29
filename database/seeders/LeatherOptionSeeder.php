<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeatherOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // database/seeders/LeatherOptionSeeder.php
public function run()
{
    LeatherOption::create([
        'name' => 'Full-Grain Italian',
        'description' => 'Premium full-grain leather',
        'price_modifier' => 50.00,
        'is_active' => true,
    ]);
    
    LeatherOption::create([
        'name' => 'Top-Grain Cowhide',
        'description' => 'Durable top-grain leather',
        'price_modifier' => 25.00,
        'is_active' => true,
    ]);
    
    LeatherOption::create([
        'name' => 'Vegetable-Tanned',
        'description' => 'Eco-friendly vegetable-tanned leather',
        'price_modifier' => 35.00,
        'is_active' => true,
    ]);
}
}
