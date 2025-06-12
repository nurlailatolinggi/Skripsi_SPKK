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
        Schema::create('indikator_ikus', function (Blueprint $table) {
            $table->id();
            $table->string('deskripsi_indikator');
            $table->string('indikator_keberhasilan');
            $table->string('parameter');
            $table->enum('frekuensi_indikator',['BULANAN','SELAMANYA']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indikator_ikus');
    }
};
