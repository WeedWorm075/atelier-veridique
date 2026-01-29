<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hardware_options', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('icon', 50)->nullable();
            $table->decimal('price_modifier', 10, 2)->default(0);
            $table->boolean('available')->default(true);
            $table->timestamps();
            
            $table->index('available');
        });
    }

    public function down()
    {
        Schema::dropIfExists('hardware_options');
    }
};