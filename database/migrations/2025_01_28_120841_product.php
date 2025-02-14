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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name',100);
            $table->bigInteger('brand_id')->default(0);
            $table->bigInteger('category_id')->default(0);
            $table->decimal('product_mrp', total: 8, places: 2)->default(0);
            $table->decimal('product_price', total: 8, places: 2)->default(0);
            $table->tinyInteger('product_tax')->default(0);
            $table->tinyInteger('product_stock')->default(0);
            $table->text('product_detail')->nullable();
            $table->tinyInteger('product_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
