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
        Schema::create('order_masters', function (Blueprint $table) {
            $table->id();
            $table->string('order_master_id',100);
            $table->bigInteger('cart_id');
            $table->bigInteger('user_id');
            $table->dateTime('order_date');
            $table->decimal('sub_total', total: 8, places: 2)->default(0);
            $table->decimal('other_amt', total: 8, places: 2)->default(0);
            $table->decimal('total_amt', total: 8, places: 2)->default(0);
            $table->tinyInteger('payment_status');
            $table->tinyInteger('order_status');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_masters');
    }
};
