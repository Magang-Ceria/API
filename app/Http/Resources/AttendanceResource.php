<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
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
            'morningtime' => $this->morningtime,
            'morningstatus' => $this->morningstatus,
            'afternoontime' => $this->afternoontime,
            'afternoonstatus' => $this->afternoonstatus,
            'proof' => $this->proof,
            'date' => new DateResource($this->whenLoaded('date')),
            'interns' => $this->attendanceable,
        ];
    }
}