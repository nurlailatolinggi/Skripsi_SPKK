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
        Schema::create('upload_ikus', function (Blueprint $table) {
            $table->id();
            $table->string('path_file_iku');
            $table->foreignId('karyawan_id')->constrained('karyawans')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('indikator_iku_id')->constrained('indikator_ikus')->onUpdate('cascade')->onDelete('cascade');
            $table->year('tahun');
            $table->tinyInteger('bulan');
            $table->enum('status',['BARU','TIDAK VALID','VALID'])->default('BARU');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upload_ikus');
    }
};
