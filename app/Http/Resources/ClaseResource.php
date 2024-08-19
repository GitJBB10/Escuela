<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClaseResource extends JsonResource
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
            'curso_id' => $this->curso->id,
            'nombre_curso' => $this->curso->nombre_curso,
            'materia_id' => $this->materia->id,
            'nombre_materia' => $this->materia->nombre_materia,
            'profesor_id' => $this->profesor->id,
            'nombre_profesor' => $this->profesor->persona->nombres.' '.$this->profesor->persona->apellidos,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
        ];
    }
}
