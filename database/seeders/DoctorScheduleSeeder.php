<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DoctorScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = Doctor::all();

        // Horários possíveis (sem o intervalo de almoço)
        $possibleTimes = [];

        // Manhã: 08:00 até 11:30
        foreach (range(8, 11) as $hour) {
            foreach ([0, 30] as $minute) {
                $possibleTimes[] = sprintf('%02d:%02d:00', $hour, $minute);
            }
        }

        // Tarde: 13:00 até 17:30
        foreach (range(13, 17) as $hour) {
            foreach ([0, 30] as $minute) {
                $possibleTimes[] = sprintf('%02d:%02d:00', $hour, $minute);
            }
        }

        foreach ($doctors as $doctor) {
            for ($day = 0; $day < 14; $day++) {
                $date = Carbon::today()->addDays($day);

                // pula fins de semana
                if ($date->isWeekend()) {
                    continue;
                }

                // escolhe de 0 a 4 horários aleatórios para o dia
                $timesForDay = collect($possibleTimes)
                    ->shuffle()
                    ->take(rand(0, 4));

                // cria os horários
                foreach ($timesForDay as $time) {
                    DoctorSchedule::factory()->create([
                        'doctor_id' => $doctor->id,
                        'date'      => $date->toDateString(),
                        'time'      => $time,
                        'available' => true,
                    ]);
                }
            }
        }
    }
}
