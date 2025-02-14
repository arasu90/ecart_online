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
            $table->bigInteger('user_id');
            $table->datetime('order_date')->nullable();
            $table->bigInteger('total_order_item')->default(0);
            $table->string('payment_mode',100)->nullable();
            $table->string('payment_reference_no',150)->nullable();
            $table->text('billing_details')->nullable();
            $table->decimal('item_value', total: 8, places: 2)->default(0);
            $table->decimal('discount_amt', total: 8, places: 2)->default(0);
            $table->decimal('sub_total', total: 8, places: 2)->default(0);
            $table->decimal('tax_amt', total: 8, places: 2)->default(0);
            $table->decimal('total_amt', total: 8, places: 2)->default(0);
            $table->decimal('shipping_amt', total: 8, places: 2)->default(0);
            $table->decimal('net_total_amt', total: 8, places: 2)->default(0);
            $table->tinyInteger('payment_status')->default(0);
            $table->tinyInteger('order_status')->default(0);
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
