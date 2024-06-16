<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('car_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('brand_id');
            $table->timestamps();

            $table->foreign('brand_id')->references('id')->on('brand');
        });

        DB::table('car_models')->insert([
            [
                'name' => 'Camry',
                'brand_id' => 1,
            ],
            [
                'name' => 'Corolla',
                'brand_id' => 1,
            ],
            [
                'name' => 'RAV4',
                'brand_id' => 1,
            ],
            [
                'name' => 'Golf',
                'brand_id' => 2,
            ],
            [
                'name' => 'Passat',
                'brand_id' => 2,
            ],
            [
                'name' => 'Tiguan',
                'brand_id' => 2,
            ],
            [
                'name' => 'Mustang',
                'brand_id' => 3,
            ],
            [
                'name' => 'Focus',
                'brand_id' => 3,
            ],
            [
                'name' => 'Escape',
                'brand_id' => 3,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_models');
    }
};
