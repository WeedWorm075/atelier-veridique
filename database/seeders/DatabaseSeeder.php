<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\LeatherOption;
use App\Models\HardwareOption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@atelier-veridique.com',
            'password' => Hash::make('password'),
        ]);

        // Create main product
        $product = Product::create([
            'name' => 'Artisan Satchel',
            'slug' => 'artisan-satchel',
            'description' => 'Handcrafted leather satchel made with ethical and sustainable materials',
            'base_price' => 420.00,
            'status' => 'active',
        ]);

        // Create leather options
        $leatherOptions = [
            [
                'name' => 'Heritage Brown',
                'description' => 'Classic full-grain leather that develops rich character over decades',
                'color_code' => '#2C2416',
                'price_modifier' => 0.00,
                'available' => true,
            ],
            [
                'name' => 'Chestnut',
                'description' => 'Medium tan with warm undertones, ages to beautiful honey tones',
                'color_code' => '#8B7355',
                'price_modifier' => 0.00,
                'available' => true,
            ],
            [
                'name' => 'Walnut',
                'description' => 'Deep brown with chocolate hues, formal and distinguished appearance',
                'color_code' => '#5A4A3A',
                'price_modifier' => 0.00,
                'available' => true,
            ],
        ];

        foreach ($leatherOptions as $option) {
            LeatherOption::create($option);
        }

        // Create hardware options
        $hardwareOptions = [
            [
                'name' => 'Polished Brass',
                'description' => 'Classic shine that develops a natural patina over time',
                'icon' => '✨',
                'price_modifier' => 0.00,
                'available' => true,
            ],
            [
                'name' => 'Antique Brass',
                'description' => 'Matte finish with vintage appeal, pre-aged look',
                'icon' => '🛡️',
                'price_modifier' => 0.00,
                'available' => true,
            ],
            [
                'name' => 'Blackened Steel',
                'description' => 'Modern, durable finish with industrial character',
                'icon' => '⚫',
                'price_modifier' => 0.00,
                'available' => true,
            ],
        ];

        foreach ($hardwareOptions as $option) {
            HardwareOption::create($option);
        }

        // Create inventory items
        $leatherOptions = LeatherOption::all();
        $hardwareOptions = HardwareOption::all();

        foreach ($leatherOptions as $leatherOption) {
            foreach ($hardwareOptions as $hardwareOption) {
                $product->inventoryItems()->create([
                    'leather_option_id' => $leatherOption->id,
                    'hardware_option_id' => $hardwareOption->id,
                    'quantity' => 100,
                    'reserved_quantity' => 0,
                    'reorder_point' => 10,
                ]);
            }
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin user created: admin@atelier-veridique.com / password');
    }
}