<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Profesor;
use App\Http\Resources\ProfesorResource;
use App\Http\Requests\ProfesorRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfesorController extends Controller
{

    public function index()
    {
        return ProfesorResource::collection(Profesor::with('persona')->get());
    }


    public function store(ProfesorRequest $request)
    {
       $personaData = [
          'nombres' => $request['nombres'],
          'apellidos' => $request['apellidos'],
          'mail' => $request['mail'],
          'genero' => $request['genero'],
          'f_nacimiento' => $request['f_nacimiento'],
          'direccion' => $request['direccion'],
       ];
    
       $profesorData = [
            'identificacion' => $request['identificacion'],
            'estado_civil' => $request['estado_civil'],
            'telefono' => $request['telefono']
       ];
       
       $persona = Persona::create($personaData); 
       $profesor = new Profesor($profesorData);
       $persona->profesor()->save($profesor); 

       return new ProfesorResource($profesor->load('persona'));
    }


    public function show(string $id)
    {
        $profesor = Profesor::with('persona')->findOrFail($id);
        return new ProfesorResource($profesor); 
    }

   
    public function update(ProfesorRequest $request, string $id)
    {
        $profesor = Profesor::findOrFail($id);
        $persona = $profesor->persona;

        $personaData = [
            'nombres' => $request['nombres'],
            'apellidos' => $request['apellidos'],
            'mail' => $request['mail'],
            'genero' => $request['genero'],
            'f_nacimiento' => $request['f_nacimiento'],
            'direccion' => $request['direccion'],
         ];
      
         $profesorData = [
              'identificacion' => $request['identificacion'],
              'estado_civil' => $request['estado_civil'],
              'telefono' => $request['telefono']
         ];

        $persona->update($personaData);
        $profesor->update($profesorData);
        return new ProfesorResource($profesor->load('persona'));
    }


    public function destroy(string $id)
    {
        $profesor = Profesor::findOrFail($id);
        $profesor->delete();
        $profesor->persona->delete();

        return response()->json(NULL, 204);
    }
}
