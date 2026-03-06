<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>  $this->id,
            'libelle' => $this->libelle,
            'professeur' => $this->professeur,
            'volume_horaire' => $this->volume_horaire,
            'etudiants' => EtudiantResource::collection($this->whenLoaded('etudiants')),
            'created_at' => $this->creates_at,
        ];
    }
}
