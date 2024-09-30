<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Estudiante;
use App\Http\Requests\EstudianteRequest;
use App\Http\Resources\EstudianteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EstudianteController extends Controller
{

    public function index()
    {
       /* return Estudiante::with('persona')->get();*/
        return EstudianteResource::collection(Estudiante::with('persona')->get());
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $personaData = $request->validate([
            'nombres' => 'required|string|max:60',
            'apellidos' => 'required|string|max:60',
            'mail' => 'required|string|email|max:120',
            'genero' => 'required|string',
            'f_nacimiento' => 'required|date',
            'direccion' => 'required|string|max:200',
        ]);

        $estudianteData = [
            'identificacion' => $request['identificacion'],
            'representante_id' => $request['representante_id'],
       ];
        
       $persona = Persona::create($personaData); 
       $estudiante = new Estudiante($estudianteData);
       $persona->estudiante()->save($estudiante); 

       return response()->json($estudiante->load('persona'), 201);    

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $estudiante = Estudiante::with('persona')->findOrFail($id);
        return new EstudianteResource($estudiante);    
        /*return response()->json($estudiante,200);*/
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $persona = $estudiante->persona;

        $personaData = [
            'nombres' => $request['nombres'],
            'apellidos' => $request['apellidos'],
            'mail' => $request['mail'],
            'genero' => $request['genero'],
            'f_nacimiento' => $request['f_nacimiento'],
            'direccion' => $request['direccion'],
         ];

        $estudianteData = [
            'identificacion' => $request['identificacion']
       ];

        $persona->update($personaData);
        $estudiante->update($estudianteData);
        return new EstudianteResource($estudiante->load('persona'));

        /*return response()->json($estudiante->load('persona'));*/
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $estudiante->delete();
        $estudiante->persona->delete();
        
        return response()->json(null, 204);
    }
}
