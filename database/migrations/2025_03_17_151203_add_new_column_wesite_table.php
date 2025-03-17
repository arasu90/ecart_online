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
        Schema::table('websites', function (Blueprint $table) {
            $table->decimal('delivery_charge', total: 8, places: 2)->default(0);
            $table->decimal('delivery_free_charge', total: 8, places: 2)->default(0);
            $table->string('delivery_free_charge_notes',200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn('delivery_charge');
            $table->dropColumn('delivery_free_charge');
            $table->dropColumn('delivery_free_charge_notes');
        });
    }
};
