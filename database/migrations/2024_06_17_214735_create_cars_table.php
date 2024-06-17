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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('car_models_id');
            $table->decimal('price', 8, 2);
            $table->boolean('availability')->default(true);
            $table->integer('year');
            $table->string('fuel_type');
            $table->string('transmission');
            $table->integer('seats');
            $table->string('color');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

        });
        Schema::table('cars', function (Blueprint $table) {
            $table->foreign('brand_id')->references('id')->on('brand');
            $table->foreign('car_models_id')->references('id')->on('car_models');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
