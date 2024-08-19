<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matricula;
use App\Http\Resources\MatriculaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MatriculaController extends Controller
{

    public function index()
    {
        /*return Matricula::with(['estudiante', 'curso', 'periodo'])->get();*/
        return MatriculaResource::collection(Matricula::with('estudiante', 'curso', 'periodo')->get());
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'periodo_id' => 'required|exists:periodos,id',
            'estudiante_id' => 'required|exists:estudiantes,id',
            'curso_id' => 'required|exists:cursos,id',
            'estado' => 'required|string|max:60',
            
        ]);

       $matricula = Matricula::create($validatedData); 
       
       return response()->json($matricula->load('periodo', 'estudiante', 'curso'), 201);
    }


    public function show(string $id)
    {
        $matricula = Matricula::with(['estudiante', 'curso', 'periodo'])->findOrFail($id);
        return new MatriculaResource($matricula); 
    }


    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'periodo_id' => 'required|exists:periodos,id',
            'estudiante_id' => 'required|exists:estudiantes,id',
            'curso_id' => 'required|exists:cursos,id',
            'estado' => 'required|string|max:60',
            
        ]);

        $matricula = Matricula::findOrFail($id);
        $matricula->update($validatedData);

        return response()->json($matricula->load(['estudiante', 'curso', 'periodo']));
    }


    public function destroy(string $id)
    {
        $matricula = Matricula::findOrFail($id);
        $matricula->delete();

        // Devolver una respuesta sin contenido
        return response()->json([
            'success'=> true
        ],200);
    }
}
