<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Fluent;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('name', 'product_name');
            $table->renameColumn('category', 'product_category'); 
            $table->renameColumn('sizes', 'product_size');
            $table->renameColumn('price', 'product_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('product_name', 'name');
            $table->renameColumn('product_category', 'category'); 
            $table->renameColumn('product_size', 'sizes');
            $table->renameColumn('product_price', 'price');
        });
    }
};

