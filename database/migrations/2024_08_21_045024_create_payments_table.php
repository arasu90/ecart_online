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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id',100);
            $table->bigInteger('order_master_id');
            $table->bigInteger('user_id');
            $table->dateTime('order_date');
            $table->decimal('total_amt', total: 8, places: 2)->default(0);
            $table->tinyInteger('payment_status');
            $table->string('payment_remarks',200);
            $table->string('payment_reference',200);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
