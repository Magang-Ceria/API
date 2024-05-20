<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndividualInternResource extends JsonResource
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
            'address' => $this->address,
            'institution' => $this->institution,
            'startperiode' => $this->startperiode,
            'endperiode' => $this->endperiode,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'user' => $this->whenLoaded('user'),
            'attendance' => $this->whenLoaded('attendance'),
            'document' => $this->whenLoaded('document')
        ];
    }
}
