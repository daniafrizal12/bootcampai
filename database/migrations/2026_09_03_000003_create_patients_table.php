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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('medical_record_number')->unique()->comment('Nomor Rekam Medis (RM)');
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->timestampTz('email_verified_at')->nullable();
            $table->rememberToken();
            $table->date('date_of_birth');
            $table->string('gender')->comment('male, female');
            $table->string('national_id')->unique()->nullable()->comment('NIK Pasien');
            $table->string('phone');
            $table->text('address')->nullable();
            $table->string('blood_type')->nullable()->comment('A, B, AB, O');
            $table->jsonb('allergies')->nullable()->comment('Daftar riwayat alergi obat/makanan');
            $table->string('photo')->nullable();
            $table->timestampsTz();

            $table->index('name');
            $table->index('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
