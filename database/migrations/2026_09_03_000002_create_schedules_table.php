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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week')->nullable()->comment('0=Minggu, 1=Senin, ..., 6=Sabtu');
            $table->date('specific_date')->nullable()->comment('Untuk jadwal one-time / khusus');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('max_patients')->default(20);
            $table->string('status')->default('active')->comment('active, inactive, cancelled');
            $table->string('type')->default('recurring')->comment('recurring, one_time');
            $table->text('notes')->nullable();
            $table->timestampsTz();

            $table->index(['doctor_id', 'status']);
            $table->index(['day_of_week', 'status']);
            $table->index(['specific_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
