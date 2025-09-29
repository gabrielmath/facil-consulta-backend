<?php

use App\Enums\AppointmentStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->cascadeOnDelete(); // patient is a user
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->foreignId('doctor_schedule_id')->constrained('doctor_schedules')->cascadeOnDelete();
            $table->enum(
                'status',
                [
                    AppointmentStatusEnum::CANCELLED,
                    AppointmentStatusEnum::SCHEDULED,
                    AppointmentStatusEnum::FINALIZED
                ]
            )->default(AppointmentStatusEnum::SCHEDULED);
            $table->timestamps();

            $table->unique(['patient_id', 'doctor_id', 'doctor_schedule_id']);
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
