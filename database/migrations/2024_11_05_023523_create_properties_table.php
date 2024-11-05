<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class); 
            $table->string('name');
            $table->string('logo');
            $table->string('slogan');
            $table->string('description');
            $table->string('location');
            $table->double('min_price', 10, 2);
            $table->double('max_price', 10, 2);
            $table->string('status');
            $table->integer('percent');
            $table->json('media')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
