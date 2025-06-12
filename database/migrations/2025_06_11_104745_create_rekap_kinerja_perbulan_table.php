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
        Schema::create('rekap_kinerja_perbulans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('karyawan_id')->constrained('karyawans')->onDelete('cascade');

            $table->unsignedTinyInteger('bulan'); // 1-12
            $table->year('tahun');

            $table->decimal('persentase_kinerja', 5, 2); // contoh: 87.50 (%)

            $table->timestamps();

            $table->unique(['karyawan_id', 'bulan', 'tahun']); // agar tidak duplikat
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_kinerja_perbulan');
    }
};
