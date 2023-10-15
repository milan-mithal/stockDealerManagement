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
        Schema::create('sub_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->integer('dealer_id')->default(0);
            $table->integer('user_id')->default(0);
            $table->float('total_amount', 20,2);
            $table->string('order_status');
            $table->string('order_placed',3)->default('No');
            $table->longText('order_remarks');
            $table->string('currency',5);
            $table->integer('percentage')->default(0);
            $table->string('rate',20);
            $table->date('order_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_orders');
    }
};
