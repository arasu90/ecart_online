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
        Schema::create('my_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('contact_name',50);
            $table->string('contact_mobile',20);
            $table->string('address_line1',150);
            $table->string('address_line2',150)->nullable();
            $table->string('address_line3',150)->nullable();
            $table->string('address_city',150);
            $table->string('address_state',150);
            $table->string('address_pincode',10);
            $table->tinyInteger('make_default')->default(0);
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_addresses');
    }
};
