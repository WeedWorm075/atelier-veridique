<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\LeatherOption;
use App\Models\HardwareOption;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create main product
        $product = Product::create([
            'name' => 'Artisan Satchel',
            'slug' => 'artisan-satchel',
            'description' => 'Handcrafted leather satchel made with ethical and sustainable materials',
            'base_price' => 420.00,
            'status' => 'active'
        ]);

        // Create leather options
        $leatherOptions = [
            [
                'name' => 'Heritage Brown',
                'description' => 'Classic full-grain, develops rich character over decades',
                'color_code' => 'linear-gradient(135deg, #2C2416 0%, #4A3C2A 100%)',
                'price_modifier' => 0.00,
                'available' => true
            ],
            [
                'name' => 'Chestnut',
                'description' => 'Medium tan with warm undertones, ages to honey tones',
                'color_code' => 'linear-gradient(135deg, #8B7355 0%, #A68968 100%)',
                'price_modifier' => 0.00,
                'available' => true
            ],
            [
                'name' => 'Walnut',
                'description' => 'Deep brown with chocolate hues, formal and distinguished',
                'color_code' => 'linear-gradient(135deg, #5A4A3A 0%, #7A6A5A 100%)',
                'price_modifier' => 0.00,
                'available' => true
            ]
        ];

        foreach ($leatherOptions as $option) {
            LeatherOption::create($option);
        }

        // Create hardware options
        $hardwareOptions = [
            [
                'name' => 'Polished Brass',
                'description' => 'Classic shine, develops natural patina over time',
                'icon' => '✨',
                'price_modifier' => 0.00,
                'available' => true
            ],
            [
                'name' => 'Antique Brass',
                'description' => 'Matte finish with vintage appeal, pre-aged look',
                'icon' => '🛡️',
                'price_modifier' => 0.00,
                'available' => true
            ],
            [
                'name' => 'Blackened Steel',
                'description' => 'Modern, durable finish with industrial character',
                'icon' => '⚫',
                'price_modifier' => 0.00,
                'available' => true
            ]
        ];

        foreach ($hardwareOptions as $option) {
            HardwareOption::create($option);
        }
    }
}