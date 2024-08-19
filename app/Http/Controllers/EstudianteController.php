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
   
        $validatedData = $request->validate([
            'nombres' => 'required|string|max:60',
            'apellidos' => 'required|string|max:60',
            'mail' => 'required|string|email|max:120',
            'genero' => 'required|string',
            'f_nacimiento' => 'required|date',
            'direccion' => 'required|string|max:200',
        ]);
        
       $persona = Persona::create($validatedData); 
       $estudiante = new Estudiante(['representante_id' => $request['representante_id']]);
       $persona->estudiante()->save($estudiante); 

       return response()->json($estudiante->load('persona'), 201);

    /*
            {
            "nombres": "Pedro",
            "apellidos":"Bustos",
            "mail":"correo2@mail.com",
            "genero":"M",
            "f_nacimiento":"2002-05-05",
            "direccion":"Direccion"
            }
      */      

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

        $validatedData = $request->validate([
            'nombres' => 'required|string|max:60',
            'apellidos' => 'required|string|max:60',
            'mail' => 'required|string|email|max:120',
            'genero' => 'required|string',
            'f_nacimiento' => 'required|date',
            'direccion' => 'required|string|max:200'. $persona->id, 
        ]);

        $persona->update($validatedData);
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
