<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('leather_option_id')->nullable()->constrained('leather_options');
            $table->foreignId('hardware_option_id')->nullable()->constrained('hardware_options');
            $table->integer('quantity')->default(0);
            $table->integer('reserved_quantity')->default(0);
            $table->integer('reorder_point')->default(10);
            $table->timestamps();
            
            // Composite index for unique combination
            $table->unique(['product_id', 'leather_option_id', 'hardware_option_id'], 
                         'inventory_composite_unique');
            
            // Indexes
            $table->index('product_id');
            $table->index(['leather_option_id', 'hardware_option_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_items');
    }
};