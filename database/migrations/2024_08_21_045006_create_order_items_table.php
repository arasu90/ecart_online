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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_master_id');
            $table->bigInteger('user_id');
            $table->string('product_name',100);
            $table->string('color_name',50);
            $table->tinyInteger('product_qty');
            $table->decimal('product_mrp', total: 8, places: 2)->default(0);
            $table->decimal('product_rate', total: 8, places: 2)->default(0);
            $table->decimal('sub_total', total: 8, places: 2)->default(0);
            $table->decimal('discount_amt', total: 8, places: 2)->default(0);
            $table->decimal('gst_per', total: 8, places: 2)->default(0);
            $table->decimal('gst_amt', total: 8, places: 2)->default(0);
            $table->decimal('total_amt', total: 8, places: 2)->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
