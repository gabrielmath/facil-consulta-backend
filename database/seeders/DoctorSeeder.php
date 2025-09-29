<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialties = [
            'Cardiologista',
            'Oftalmologista',
            'Neurologista',
            'Otorrinolaringologista',
            'Dermatologista',
            'Ortopedista',
            'Nutricionista',
            'Psiquiatra',
        ];

        foreach ($specialties as $specialty) {
            $user = User::factory()->create();
            
            Doctor::factory()->create([
                'user_id'   => $user->id,
                'specialty' => $specialty
            ]);
        }
    }
}
