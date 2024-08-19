<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfesorResource extends JsonResource
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
            'identificacion' => $this->identificacion,
            'nombres' => $this->persona->nombres,
            'apellidos' => $this->persona->apellidos,
            'mail' => $this->persona->mail,
            'genero' => $this->persona->genero,
            'f_nacimiento' => $this->persona->f_nacimiento,
            'estado_civil' => $this->estado_civil,
            'telefono' => $this->telefono,
            'direccion' => $this->persona->direccion,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),

        ];
    }
}
