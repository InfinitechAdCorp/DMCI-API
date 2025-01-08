<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('agent_profiles', function (Blueprint $table) {
        $table->ulid('id')->primary();
        $table->foreignUlid('user_id');
        $table->string('image'); 
        $table->string('first_name');
        $table->string('last_name');
        $table->string('position');
        $table->string('email');
        $table->string('phone_number');
        $table->string('facebook')->nullable();
        $table->string('instagram')->nullable();
        $table->string('telegram')->nullable();
        $table->string('viber')->nullable();
        $table->string('whatsapp')->nullable();
        $table->text('about_me')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_profiles');
    }
};
