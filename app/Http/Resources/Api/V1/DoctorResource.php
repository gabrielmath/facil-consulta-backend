<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    public static $wrap = 'doctor';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->user->name,
            'specialty'    => $this->specialty,
            'full_address' => $this->full_address,
            'schedules'    => $this->schedules
                ->where('available', true)
                ->groupBy(fn($schedule) => $schedule->date->toDateString())
                ->map(function ($items) {
                    return $items->sortBy('time')->map(function ($schedule) {
                        return [
                            'id'   => $schedule->id,
                            'time' => \Carbon\Carbon::createFromFormat('H:i:s', $schedule->time)->format('H:i:s'),
                        ];
                    })->values();
                }),
        ];
    }
}
