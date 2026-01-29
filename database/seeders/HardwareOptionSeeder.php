<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HardwareOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // database/seeders/HardwareOptionSeeder.php
public function run()
{
    HardwareOption::create([
        'name' => 'Brass Hardware',
        'description' => 'Antique brass buckles and rivets',
        'price_modifier' => 15.00,
        'is_active' => true,
    ]);
    
    HardwareOption::create([
        'name' => 'Nickel Plated',
        'description' => 'Silver nickel-plated hardware',
        'price_modifier' => 10.00,
        'is_active' => true,
    ]);
    
    HardwareOption::create([
        'name' => 'Black Oxide',
        'description' => 'Matte black hardware',
        'price_modifier' => 12.00,
        'is_active' => true,
    ]);
}
}
