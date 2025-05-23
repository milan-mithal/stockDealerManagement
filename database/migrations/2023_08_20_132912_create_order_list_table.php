<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_list', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('product_code',50);
            $table->string('product_name');
            $table->string('product_category');
            $table->string('product_size');
            $table->float('original_price',8,2)
            $table->float('product_price',8,2);
            $table->integer('order_quantity');
            $table->string('order_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_list');
    }
};