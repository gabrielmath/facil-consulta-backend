<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();

        // pega horários disponíveis
        $schedules = DoctorSchedule::all();

        foreach ($patients as $patient) {
            // para cada paciente, agenda até 3 consultas aleatórias
            $randomSchedules = $schedules->random(3);

            foreach ($randomSchedules as $schedule) {
                // verifica se o horário já foi agendado
                $alreadyBooked = Appointment::where('doctor_schedule_id', $schedule->id)->exists();

                // verifica se o paciente já tem uma consulta nesse mesmo date/time
                $conflict = Appointment::where('patient_id', $patient->id)
                    ->whereHas('schedule', function ($q) use ($schedule) {
                        $q->where('date', $schedule->date)
                            ->where('time', $schedule->time);
                    })
                    ->exists();

                if (!$alreadyBooked && !$conflict) {
                    Appointment::factory()->create([
                        'patient_id'         => $patient->id,
                        'doctor_id'          => $schedule->doctor_id,
                        'doctor_schedule_id' => $schedule->id,
                        'status'             => 'scheduled',
                    ]);

                    // marca o slot como não disponível
                    $schedule->update(['available' => false]);
                }
            }
        }
    }
}
