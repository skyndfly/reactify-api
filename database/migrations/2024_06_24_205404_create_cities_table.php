<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('region_id');
            $table->timestamps();
            $table->foreign('region_id')->references('id')->on('region');
        });
        DB::table('cities')->insert([
            // Московская область
            ['name' => 'Москва', 'region_id' => 1],
            ['name' => 'Зеленоград', 'region_id' => 1],

            // Санкт-Петербург
            ['name' => 'Санкт-Петербург', 'region_id' => 2],
            ['name' => 'Пушкин', 'region_id' => 2],

            // Нижегородская область
            ['name' => 'Нижний Новгород', 'region_id' => 3],
            ['name' => 'Дзержинск', 'region_id' => 3],

            // Свердловская область
            ['name' => 'Екатеринбург', 'region_id' => 4],
            ['name' => 'Нижний Тагил', 'region_id' => 4],

            // Ростовская область
            ['name' => 'Ростов-на-Дону', 'region_id' => 5],
            ['name' => 'Таганрог', 'region_id' => 5],

            // Челябинская область
            ['name' => 'Челябинск', 'region_id' => 6],
            ['name' => 'Магнитогорск', 'region_id' => 6],

            // Самарская область
            ['name' => 'Самара', 'region_id' => 7],
            ['name' => 'Тольятти', 'region_id' => 7],

            // Красноярский край
            ['name' => 'Красноярск', 'region_id' => 8],
            ['name' => 'Норильск', 'region_id' => 8],

            // Краснодарский край
            ['name' => 'Краснодар', 'region_id' => 9],
            ['name' => 'Сочи', 'region_id' => 9],

            // Приморский край
            ['name' => 'Владивосток', 'region_id' => 10],
            ['name' => 'Находка', 'region_id' => 10],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('cities');
    }
};
