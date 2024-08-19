<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RepresentanteResource extends JsonResource
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
            'parentesco' => $this->parentesco,
            'direccion' => $this->persona->direccion,
            'telefono' => $this->telefono,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),

        ];
    }
}
