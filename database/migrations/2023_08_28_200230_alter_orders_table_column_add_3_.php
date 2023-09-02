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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('delivery_type',30);
            $table->string('third_party_details',255);
            $table->string('courier_company',255);
            $table->string('awb_number',255);
            $table->integer('modified_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->removeColumn('delivery_type');
            $table->removeColumn('third_party_details');
            $table->removeColumn('courier_company');
            $table->removeColumn('awb_number');
            $table->removeColumn('modified_by');
        });
    }
};
