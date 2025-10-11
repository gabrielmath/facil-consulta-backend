<?php

namespace App\Http\Resources\Api\V1;

use Carbon\Carbon;
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
                ->where('date', '>=', Carbon::tomorrow()->toDateString())
                ->groupBy(fn($s) => $s->date->toDateString())
                ->map(fn($items) => $items
                    ->sortBy('time')
                    ->map(fn($s) => [
                        'id'   => $s->id,
                        'time' => Carbon::createFromFormat('H:i:s', $s->time)->format('H:i'),
                    ])
                    ->values()
                ),
        ];
    }
}
