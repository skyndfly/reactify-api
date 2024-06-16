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
        Schema::create('brand', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('brand')->insert([
            ['name' =>'Toyota'],
            ['name' =>'Volkswagen'],
            ['name' =>'Ford'],
            ['name' =>'Chevrolet'],
            ['name' =>'Nissan'],
            ['name' =>'Honda'],
            ['name' =>'BMW'],
            ['name' =>'Mercedes-Benz'],
            ['name' =>'Audi'],
            ['name' => 'Hyundai']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand');
    }
};
