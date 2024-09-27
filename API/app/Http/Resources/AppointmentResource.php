<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Appointment;
use App\Http\Resources\LocationResource;
use App\Http\Resources\DeviceResource; // Ensure this import is correct and the class exists

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'guest' => new UserResource($this->guest),
            'location' => new LocationResource($this->location),
            'device' => new DeviceResource($this->devices),
            'note' => $this->note,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
