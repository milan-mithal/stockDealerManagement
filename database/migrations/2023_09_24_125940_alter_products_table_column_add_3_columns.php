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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('length')->default(0);;
            $table->integer('width')->default(0);;
            $table->integer('height')->default(0);;
            $table->integer('qty_per_box')->default(0);;
            $table->float('weight_per_box',8,2)->default(0.0);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->removeColumn('length');
            $table->removeColumn('width');
            $table->removeColumn('height');
            $table->removeColumn('qty_per_box');
            $table->removeColumn('weight_per_box');
        });
    }
};
