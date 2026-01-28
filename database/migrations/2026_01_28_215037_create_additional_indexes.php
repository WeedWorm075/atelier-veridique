<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Additional indexes for better performance
        
        // For orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->index(['status', 'payment_status']);
            $table->index(['customer_email', 'created_at']);
            $table->index(['leather_option_id', 'hardware_option_id']);
        });
        
        // For order_status_history table
        Schema::table('order_status_history', function (Blueprint $table) {
            $table->index(['status', 'created_at']);
        });
        
        // For payment_logs table
        Schema::table('payment_logs', function (Blueprint $table) {
            $table->index(['order_id', 'created_at']);
        });
        
        // For inventory_items table
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->index('quantity');
            $table->index(['quantity', 'reserved_quantity']);
        });
    }

    public function down()
    {
        // Remove indexes
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['status', 'payment_status']);
            $table->dropIndex(['customer_email', 'created_at']);
            $table->dropIndex(['leather_option_id', 'hardware_option_id']);
        });
        
        Schema::table('order_status_history', function (Blueprint $table) {
            $table->dropIndex(['status', 'created_at']);
        });
        
        Schema::table('payment_logs', function (Blueprint $table) {
            $table->dropIndex(['order_id', 'created_at']);
        });
        
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->dropIndex(['quantity']);
            $table->dropIndex(['quantity', 'reserved_quantity']);
        });
    }
};