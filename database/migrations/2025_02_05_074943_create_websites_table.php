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
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('site_logo',100);
            $table->string('site_desc',200)->nullable();
            $table->string('site_name',100);
            $table->string('site_address_line1',100);
            $table->string('site_address_line2',100)->nullable();
            $table->string('site_address_city',50);
            $table->string('site_address_state',50);
            $table->string('site_address_pincode',10);
            $table->string('site_email', 50);
            $table->string('site_mobile', 12);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};
