<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 50)->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            
            // Order status
            $table->string('status')->default('pending'); // pending, confirmed, in_production, shipped, delivered, cancelled
            $table->decimal('total_amount', 10, 2);
            $table->decimal('base_price', 10, 2);
            $table->decimal('monogram_price', 10, 2)->default(0);
            $table->decimal('shipping_price', 10, 2)->default(0);
            
            // Personalization
            $table->foreignId('leather_option_id')->nullable()->constrained('leather_options');
            $table->foreignId('hardware_option_id')->nullable()->constrained('hardware_options');
            $table->string('monogram', 20)->nullable();
            
            // Customer info
            $table->string('customer_email');
            $table->string('customer_first_name', 100)->nullable();
            $table->string('customer_last_name', 100)->nullable();
            $table->string('customer_phone', 50)->nullable();
            
            // Shipping info
            $table->text('shipping_address')->nullable();
            $table->string('shipping_city', 100)->nullable();
            $table->string('shipping_zip_code', 20)->nullable();
            $table->string('shipping_country', 100)->nullable();
            $table->string('shipping_method', 50)->default('standard');
            
            // Billing info
            $table->text('billing_address')->nullable();
            $table->string('billing_city', 100)->nullable();
            $table->string('billing_zip_code', 20)->nullable();
            $table->string('billing_country', 100)->nullable();
            
            // Payment info
            $table->string('payment_method', 50)->nullable();
            $table->string('payment_status', 20)->default('pending'); // pending, paid, failed, refunded
            $table->string('card_last_four', 4)->nullable();
            $table->string('card_brand', 50)->nullable();
            
            // Preferences
            $table->boolean('send_receipt')->default(true);
            $table->boolean('newsletter_subscription')->default(false);
            $table->boolean('terms_accepted')->default(false);
            
            // Production timeline
            $table->integer('estimated_production_days')->default(21);
            $table->date('production_start_date')->nullable();
            $table->date('production_end_date')->nullable();
            $table->date('shipped_date')->nullable();
            $table->date('delivered_date')->nullable();
            
            // Additional fields
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('order_number');
            $table->index('user_id');
            $table->index('customer_email');
            $table->index('payment_status');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};