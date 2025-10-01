<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\AppointmentStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ScheduleAnAppointmentRequest;
use App\Http\Resources\Api\V1\AppointmentResource;
use App\Http\Resources\Api\V1\DoctorResource;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function doctors()
    {
        $doctors = Doctor::query()->with(['user', 'schedules', 'appointments'])->schedulesAvailables()->get();


        return DoctorResource::collection($doctors);
    }

    public function scheduleAnAppointment(ScheduleAnAppointmentRequest $request)
    {
        $appointment = Appointment::create([
            'doctor_id'          => $request->validated('doctor_id'),
            'patient_id'         => Auth::user()->patient->id,
            'doctor_schedule_id' => $request->validated('doctor_schedule_id'),
        ]);

        return response()->json(['appointment' => $appointment, 'schedule' => $appointment->schedule], 200);
    }

    public function pastAppointments()
    {
        $appointments = Auth::user()
            ->patient
            ->appointments()
            ->with(['doctor.user', 'schedule'])
            ->where('status', AppointmentStatusEnum::FINALIZED)
            ->get();

        return AppointmentResource::collection($appointments);
    }

    public function nextAppointments()
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
