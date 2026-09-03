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
        Schema::create('queue_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained('appointments')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->foreignId('schedule_id')->constrained('schedules')->cascadeOnDelete();
            $table->date('queue_date');
            $table->unsignedInteger('queue_number');
            $table->string('prefix')->default('A')->comment('Prefix kode dokter / poli');
            $table->string('display_number')->comment('Contoh: A-001, B-012');
            $table->string('status')->default('waiting')->comment('waiting, serving, completed, skipped, cancelled');
            $table->string('priority')->default('normal')->comment('normal, priority, emergency');
            $table->string('counter')->nullable()->comment('Lokasi counter / poli pelayanan');
            $table->unsignedSmallInteger('call_count')->default(0);
            $table->timestampTz('called_at')->nullable();
            $table->timestampTz('served_at')->nullable();
            $table->timestampTz('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestampsTz();

            $table->unique(['doctor_id', 'queue_date', 'queue_number']);
            $table->index(['queue_date', 'status']);
            $table->index(['doctor_id', 'queue_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queue_tickets');
    }
};
