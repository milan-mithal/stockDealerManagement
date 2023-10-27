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
        Schema::create('sub_orders_list', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('product_code',50);
            $table->string('product_name');
            $table->string('product_category');
            $table->string('product_size');
            $table->float('original_product_price',8,2);
            $table->float('product_price',8,2);
            $table->integer('order_quantity');
            $table->string('order_status');
            $table->integer('total_boxes')->default(0);
            $table->integer('weight_per_box')->default(0);
            $table->string('box_dimension',20);
            $table->string('cbm',11);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_orders_list');
    }
};
