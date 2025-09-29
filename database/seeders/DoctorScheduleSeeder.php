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

        foreach ($doctors as $doctor) {
            for ($day = 0; $day < 14; $day++) {
                $date = Carbon::today()->addDays($day);

                if ($date->isWeekend()) {
                    continue;
                }

                foreach (range(8, 11) as $hour) {
                    foreach ([0, 30] as $minute) {
                        DoctorSchedule::factory()->create([
                            'doctor_id' => $doctor->id,
                            'date'      => $date->toDateString(),
                            'time'      => sprintf('%02d:%02d:00', $hour, $minute),
                            'available' => true,
                        ]);
                    }
                }

                foreach (range(13, 17) as $hour) {
                    foreach ([0, 30] as $minute) {
                        DoctorSchedule::factory()->create([
                            'doctor_id' => $doctor->id,
                            'date'      => $date->toDateString(),
                            'time'      => sprintf('%02d:%02d:00', $hour, $minute),
                            'available' => true,
                        ]);
                    }
                }
            }
        }
    }
}
