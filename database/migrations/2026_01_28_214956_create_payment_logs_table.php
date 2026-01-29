<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('payment_method', 50)->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('transaction_id', 255)->nullable();
            $table->string('status', 50);
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('order_id');
            $table->index('transaction_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_logs');
    }
};