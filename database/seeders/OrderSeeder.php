<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\LeatherOption;
use App\Models\HardwareOption;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Ensure users exist
        if (User::count() === 0) {
            // Create 5 users if User factory exists
            if (class_exists(\Database\Factories\UserFactory::class)) {
                User::factory()->count(5)->create();
            } else {
                // Manual creation if no factory
                for ($j = 1; $j <= 5; $j++) {
                    User::create([
                        'name' => "User {$j}",
                        'email' => "user{$j}@example.com",
                        'password' => bcrypt('password'),
                        'email_verified_at' => now(),
                    ]);
                }
            }
        }

        // Leather options
        if (LeatherOption::count() === 0) {
            LeatherOption::insert([
                ['name' => 'Full-Grain Italian', 'description' => 'Premium full-grain leather', 'price_modifier' => 50.00, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Top-Grain Cowhide', 'description' => 'Durable top-grain leather', 'price_modifier' => 25.00, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Vegetable-Tanned', 'description' => 'Eco-friendly vegetable-tanned leather', 'price_modifier' => 35.00, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // Hardware options
        if (HardwareOption::count() === 0) {
            HardwareOption::insert([
                ['name' => 'Brass Hardware', 'description' => 'Antique brass buckles and rivets', 'price_modifier' => 15.00, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Nickel Plated', 'description' => 'Silver nickel-plated hardware', 'price_modifier' => 10.00, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Black Oxide', 'description' => 'Matte black hardware', 'price_modifier' => 12.00, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        $leatherOptions = LeatherOption::all();
        $hardwareOptions = HardwareOption::all();
        $userIds = User::pluck('id');
        $statuses = ['pending', 'confirmed', 'in_production', 'shipped', 'delivered'];
        
        for ($i = 1; $i <= 10; $i++) {
            $leatherOption = $leatherOptions->random();
            $hardwareOption = $hardwareOptions->random();
            $userId = $userIds->random();
            
            $basePrice = rand(10000, 50000) / 100;
            $monogramPrice = rand(0, 3000) / 100;
            $shippingPrice = rand(500, 2500) / 100;
            
            $totalAmount = $basePrice + $monogramPrice + $shippingPrice 
                         + $leatherOption->price_modifier + $hardwareOption->price_modifier;
            
            $order = Order::create([
                'user_id' => $userId,
                'status' => $statuses[array_rand($statuses)],
                'total_amount' => $totalAmount,
                'base_price' => $basePrice,
                'monogram_price' => $monogramPrice,
                'shipping_price' => $shippingPrice,
                'leather_option_id' => $leatherOption->id,
                'hardware_option_id' => $hardwareOption->id,
                'monogram' => $i % 3 == 0 ? 'JSM' : null,
                'customer_email' => "customer{$i}@example.com",
                'customer_first_name' => fake()->firstName(),
                'customer_last_name' => fake()->lastName(),
                'customer_phone' => fake()->phoneNumber(),
                'shipping_address' => fake()->streetAddress(),
                'shipping_city' => fake()->city(),
                'shipping_zip_code' => fake()->postcode(),
                'shipping_country' => fake()->country(),
                'billing_address' => fake()->streetAddress(),
                'billing_city' => fake()->city(),
                'billing_zip_code' => fake()->postcode(),
                'billing_country' => fake()->country(),
                'payment_method' => ['stripe', 'paypal', 'bank_transfer'][rand(0, 2)],
                'payment_status' => ['pending', 'paid', 'failed'][rand(0, 2)],
                'send_receipt' => true,
                'newsletter_subscription' => rand(0, 1),
                'terms_accepted' => true,
                'estimated_production_days' => 21,
                'production_start_date' => rand(0, 1) ? now()->subDays(rand(1, 10)) : null,
                'production_end_date' => rand(0, 1) ? now()->subDays(rand(1, 5)) : null,
                'shipped_date' => rand(0, 1) ? now()->subDays(rand(1, 3)) : null,
                'delivered_date' => rand(0, 1) ? now()->subDays(1) : null,
            ]);
            
            // Create status history - FIXED: using 'status' not 'new_status'
            $order->statusHistory()->create([
                'status' => $order->status,
                'notes' => 'Order created',
            ]);
        }
    }
}