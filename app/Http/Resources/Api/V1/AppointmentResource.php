<?php

namespace App\Http\Resources\Api\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public static $wrap = 'appointments';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $status = [
            'cancelled' => 'Cancelado',
            'scheduled' => 'Agendado',
            'finalized' => 'Finalizado',
        ];

        return [
            'id'                 => $this->id,
            'doctor_id'          => $this->doctor_id,
            'doctor_schedule_id' => $this->doctor_schedule_id,
            'patient_id'         => $this->patient_id,
            'status'             => $status[$this->status],
            'doctor'             => [
                'name'         => $this->doctor->user->name,
                'specialty'    => $this->doctor->specialty,
                'full_address' => $this->doctor->full_address,
            ],
            'schedule'           => [
                'date' => $this->schedule->date->format('d/m/Y'),
                'time' => Carbon::createFromFormat('H:i:s', $this->schedule->time)->format('H:i'),
            ]
        ];
    }
}
