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
        Schema::table('order_list', function (Blueprint $table) {
            $table->integer('total_boxes')->default(0);
            $table->integer('weight_per_box')->default(0);
            $table->string('box_dimension',20);
            $table->string('cbm',11);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_list', function (Blueprint $table) {
            $table->removeColumn('total_boxes');
            $table->removeColumn('weight_per_box');
            $table->removeColumn('box_dimension');
            $table->removeColumn('cbm');
        });
    }
};
