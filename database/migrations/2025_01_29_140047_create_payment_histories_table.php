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
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_master_id');
            $table->bigInteger('user_id');
            $table->dateTime('order_date')->nullable();
            $table->decimal('total_amt', total: 8, places: 2)->default(0);
            $table->string('create_order_id',200);
            $table->string('create_order_amt',200);
            $table->string('create_order_currency_type',200);
            $table->string('create_order_receipt',200);
            $table->string('razorpay_payment_id',200);
            $table->string('razorpay_order_id',200);
            $table->string('razorpay_signature',200);
            $table->string('razorpay_status',200);
            $table->string('payment_mode',200);
            $table->text('razorpay_message')->nullable();
            $table->tinyInteger('payment_status');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_histories');
    }
};
