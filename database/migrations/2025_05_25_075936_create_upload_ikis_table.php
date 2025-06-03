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
        Schema::create('upload_ikis', function (Blueprint $table) {
            $table->id();
            $table->string('path_file_iki');
            $table->foreignId('karyawan_id')->constrained('karyawans')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('indikator_iki_id')->constrained('indikator_ikis')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status',['BARU','TIDAK VALID','VALID'])->default('BARU');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upload_ikis');
    }
};
