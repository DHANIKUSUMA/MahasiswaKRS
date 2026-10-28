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
            Schema::create('mata_kuliahs', function (Blueprint $table) {
                $table->id();

                $table->foreignId('program_studi_id')
                    ->constrained('program_studis')
                    ->restrictOnDelete();

                $table->string('kode_mk', 20)->unique();
                $table->string('nama_mk', 100);
                $table->unsignedTinyInteger('sks');
                $table->boolean('status_aktif')->default(true);
                $table->date('tanggal_dibuka')->nullable();

                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_kuliahs');
    }
};
