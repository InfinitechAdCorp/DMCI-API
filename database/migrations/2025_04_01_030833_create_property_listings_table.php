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
        Schema::create('property_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('user_id');
            $table->string('property_name');
            $table->string('property_location');
            $table->integer('property_price');
            $table->string('property_type');
            $table->string('property_size');
            $table->string('property_bldg');
            $table->string('property_level');
            $table->json('property_amenities');
            $table->boolean('property_parking');
            $table->boolean('property_featured');
            $table->json('property_images');
            $table->string('property_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_listings');
    }
};
