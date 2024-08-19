<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatriculaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'periodo'=> $this->periodo->periodo,
            'estudiante' => $this->estudiante->persona->nombres.' '.$this->estudiante->persona->apellidos,
            'curso_id' => $this->curso_id,
            'curso' => $this->curso->nombre_curso,
            'estado' => $this->estado,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
