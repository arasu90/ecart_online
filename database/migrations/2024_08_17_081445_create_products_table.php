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
            $table->string('product_name',50);
            $table->bigInteger('brand_id')->default(0)->nullable();
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->bigInteger('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->decimal('product_mrp', total: 8, places: 2)->default(0);
            $table->decimal('product_rate', total: 8, places: 2)->default(0);
            $table->string('product_desc',250)->nullable();
            $table->text('product_detail')->nullable();
            $table->tinyInteger('product_status')->default(0);
            $table->bigInteger('created_by')->unsigned()->index();
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
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
