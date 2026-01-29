<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'order_number' => $this->faker->unique()->regexify('VRD-[A-Z0-9]{10}'),
            'user_id' => null,
            'status' => Order::STATUS_PENDING,
            'total_amount' => $this->faker->randomFloat(2, 100, 1000),
            'base_price' => $this->faker->randomFloat(2, 80, 800),
            'monogram_price' => $this->faker->randomFloat(2, 0, 50),
            'shipping_price' => $this->faker->randomFloat(2, 0, 30),
            'customer_email' => $this->faker->safeEmail(),
            'customer_first_name' => $this->faker->firstName(),
            'customer_last_name' => $this->faker->lastName(),
            'customer_phone' => $this->faker->phoneNumber(),
            'payment_method' => $this->faker->randomElement(['stripe', 'paypal', 'bank_transfer']),
            'payment_status' => Order::PAYMENT_STATUS_PENDING,
            'send_receipt' => true,
            'newsletter_subscription' => $this->faker->boolean(),
            'terms_accepted' => true,
            'estimated_production_days' => 21,
        ];
    }

    public function confirmed(): self
    {
        return $this->state([
            'status' => Order::STATUS_CONFIRMED,
            'payment_status' => Order::PAYMENT_STATUS_PAID,
        ]);
    }

    public function inProduction(): self
    {
        return $this->state([
            'status' => Order::STATUS_IN_PRODUCTION,
            'payment_status' => Order::PAYMENT_STATUS_PAID,
            'production_start_date' => now()->subDays(5),
        ]);
    }

    public function shipped(): self
    {
        return $this->state([
            'status' => Order::STATUS_SHIPPED,
            'payment_status' => Order::PAYMENT_STATUS_PAID,
            'production_start_date' => now()->subDays(10),
            'production_end_date' => now()->subDays(2),
            'shipped_date' => now()->subDays(1),
        ]);
    }

    public function delivered(): self
    {
        return $this->state([
            'status' => Order::STATUS_DELIVERED,
            'payment_status' => Order::PAYMENT_STATUS_PAID,
            'production_start_date' => now()->subDays(20),
            'production_end_date' => now()->subDays(12),
            'shipped_date' => now()->subDays(10),
            'delivered_date' => now()->subDays(1),
        ]);
    }

    public function cancelled(): self
    {
        return $this->state([
            'status' => Order::STATUS_CANCELLED,
        ]);
    }

    public function withUser($userId): self
    {
        return $this->state([
            'user_id' => $userId,
        ]);
    }

    public function withAddress(): self
    {
        return $this->state([
            'shipping_address' => $this->faker->streetAddress(),
            'shipping_city' => $this->faker->city(),
            'shipping_zip_code' => $this->faker->postcode(),
            'shipping_country' => $this->faker->country(),
            'billing_address' => $this->faker->streetAddress(),
            'billing_city' => $this->faker->city(),
            'billing_zip_code' => $this->faker->postcode(),
            'billing_country' => $this->faker->country(),
        ]);
    }
}