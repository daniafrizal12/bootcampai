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
        Schema::create('service_counters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nama ruangan / counter');
            $table->string('code')->unique()->comment('Kode counter, misal: C-01, POLI-UMUM');
            $table->string('location')->nullable()->comment('Lantai / Gedung / Sayap');
            $table->boolean('is_active')->default(true);
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_counters');
    }
};
