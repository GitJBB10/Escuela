<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clase;
use App\Http\Resources\ClaseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ClaseController extends Controller
{
    public function index()
    {
        return Clase::with('curso', 'materia', 'profesor')->get();
        /*return ClaseResource::collection(Clase::with('curso', 'materia', 'profesor')->get());*/
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'materia_id' => 'required|exists:materias,id',
            'profesor_id' => 'required|exists:profesores,id',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
        ]);

       $clase = Clase::create($validatedData); 
       
       return response()->json($clase->load('curso', 'materia', 'profesor'), 201);
    }


    public function show(string $id)
    {
        $clase = Clase::with(['curso', 'materia', 'profesor'])->findOrFail($id);
        return new ClaseResource($clase); 
    }

  
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'materia_id' => 'required|exists:materias,id',
            'profesor_id' => 'required|exists:profesores,id',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
        ]);

        $clase = Clase::findOrFail($id);
        $clase->update($validatedData);

        return response()->json($clase->load(['curso', 'materia', 'profesor']));
    }


    public function destroy(string $id)
    {
        $clase = Clase::findOrFail($id);
        $clase->delete();

        // Devolver una respuesta sin contenido
        return response()->json([
            'success'=> true
        ],200);
    }
}
