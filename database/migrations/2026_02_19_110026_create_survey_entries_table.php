<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('survey_entries', function (Blueprint $table) {
            $table->id();
            $table->string('dni');
            $table->string('last_name');
            $table->string('name');
            $table->string('phone');
            $table->string('table_number');
            $table->string('visit_time', 5)->nullable();

            $table->string('brings_kids');
            $table->json('kids_ages')->nullable(); // JSON para guardar múltiples opciones
            $table->string('useful_play_area');
            $table->string('visit_more_often');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_entries');
    }
};
