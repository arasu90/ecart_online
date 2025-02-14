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
        Schema::create('offer_data', function (Blueprint $table) {
            $table->id();
            $table->string('offer_type', 50);
            $table->bigInteger('offered_id');
            $table->string('offer_title', 100);
            $table->string('offer_description', 255);
            $table->string('offer_image', 255);
            $table->date('offer_start_date');
            $table->date('offer_end_date');
            $table->tinyInteger('offer_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_data');
    }
};
