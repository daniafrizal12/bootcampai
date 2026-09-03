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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique()->comment('Format: APT-YYYYMMDD-XXXX');
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->foreignId('schedule_id')->constrained('schedules')->cascadeOnDelete();
            $table->date('appointment_date');
            $table->time('estimated_time')->nullable();
            $table->string('visit_type')->default('new_visit')->comment('new_visit, follow_up');
            $table->text('chief_complaint')->nullable()->comment('Keluhan utama');
            $table->text('patient_notes')->nullable();
            $table->string('status')->default('pending')->comment('pending, confirmed, checked_in, in_progress, completed, cancelled, no_show');
            $table->string('source')->default('online')->comment('online, walk_in, phone');
            $table->text('cancellation_reason')->nullable();
            $table->timestampTz('cancelled_at')->nullable();
            $table->timestampTz('checked_in_at')->nullable();
            $table->string('check_in_method')->nullable()->comment('self_service, counter, qr_scan');
            $table->foreignId('checked_in_by')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedBigInteger('created_by')->nullable()->comment('ID User/Dokter pembuat data');
            $table->jsonb('metadata')->nullable();
            $table->timestampsTz();

            $table->index(['doctor_id', 'appointment_date', 'status']);
            $table->index(['patient_id', 'appointment_date']);
            $table->index(['appointment_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
