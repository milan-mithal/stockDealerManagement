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
        Schema::table('users', function (Blueprint $table) {
            $table->string('dealer_name',300);
            $table->string('address',300);
            $table->string('region',50);
            $table->string('community',50);
            $table->string('phone_no');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('dealer_name');
            $table->dropColumn('address');
            $table->dropColumn('region');
            $table->dropColumn('community');
            $table->dropColumn('phone_no');
        });
    }
};
