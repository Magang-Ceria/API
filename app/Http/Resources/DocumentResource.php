<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'registrationLetter' => $this->registrationletter,
            'acceptanceLetter' => $this->acceptanceletter,
            'intern' => $this->whenLoaded('documentable')
        ];
    }
}
