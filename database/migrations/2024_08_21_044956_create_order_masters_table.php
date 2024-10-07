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
            $table->bigInteger('total_order_qty')->default(0);
            $table->datetime('order_date')->nullable();
            $table->string('payment_mode',100)->nullable();
            $table->string('payment_reference_no',150)->nullable();
            $table->text('billing_details')->nullable();
            $table->decimal('sub_total', total: 8, places: 2)->default(0);
            $table->decimal('other_amt', total: 8, places: 2)->default(0);
            $table->decimal('total_amt', total: 8, places: 2)->default(0);
            $table->tinyInteger('payment_status')->default(0); // 0 inactive 1 Inprogress 2 onverify payment 3 failed 4 payment done
            $table->tinyInteger('order_status')->default(0); // 0 inactive 1 waiting for payment confirm 2 payment done ready to ship 3 moved to shipping 4 out for Delivery 5 delivery success 6 delivery failed
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
