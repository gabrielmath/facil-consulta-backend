<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\AppointmentStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ScheduleAnAppointmentRequest;
use App\Http\Resources\Api\V1\AppointmentResource;
use App\Http\Resources\Api\V1\DoctorResource;
use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function doctors(): AnonymousResourceCollection
    {
        // Subquery para pegar o próximo horário disponível de cada médico
        $nextSchedule = DB::table('doctor_schedules')
            ->select('doctor_id', DB::raw("MIN(CONCAT(date, ' ', time)) as next_available"))
            ->where('available', true)
            ->where('date', '>=', Carbon::tomorrow()->toDateString())
            ->groupBy('doctor_id');

        $doctors = Doctor::query()
            ->joinSub($nextSchedule, 'next_schedule', function ($join) {
                $join->on('next_schedule.doctor_id', '=', 'doctors.id');
            })
            ->with(['user', 'schedules', 'appointments'])
            ->schedulesAvailables()
            ->orderBy('next_schedule.next_available') // Médico com horário mais próximo primeiro
            ->select('doctors.*')
            ->get();


        return DoctorResource::collection($doctors);
    }

    public function scheduleAnAppointment(ScheduleAnAppointmentRequest $request): JsonResponse
    {
        $appointment = Appointment::create([
            'doctor_id'          => $request->validated('doctor_id'),
            'patient_id'         => Auth::user()->patient->id,
            'doctor_schedule_id' => $request->validated('doctor_schedule_id'),
        ]);

        return response()->json(['appointment' => $appointment, 'schedule' => $appointment->schedule], 200);
    }

    public function pastAppointments(): AnonymousResourceCollection
    {
        $appointments = Auth::user()
            ->patient
            ->appointments()
            ->with(['doctor.user', 'schedule'])
            ->where('status', AppointmentStatusEnum::FINALIZED)
            ->get();

        return AppointmentResource::collection($appointments);
    }

    public function nextAppointments(): AnonymousResourceCollection
    {
        $appointments = Auth::user()
            ->patient
            ->appointments()
            ->with(['doctor.user', 'schedule'])
            ->where('status', AppointmentStatusEnum::SCHEDULED)
            ->get();

        return AppointmentResource::collection($appointments);
    }
}
