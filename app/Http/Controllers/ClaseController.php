<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clase;
use App\Http\Resources\ClaseResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClasesExport;

class ClaseController extends Controller
{
    public function index()
    {
        //return Clase::with('curso', 'materia', 'profesor')->get();
        return ClaseResource::collection(Clase::with('curso', 'materia', 'profesor')->get());
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

    public function reporteClases(Request $request)
    {
        $curso = $request->query('curso', '');
        $materia = $request->query('materia', '');
        $profesor = $request->query('profesor', '');

        // Filtrar clases según los parámetros
        $query = Clase::query();

                
        if ($curso) {
            $query->whereHas('curso', function($q) use ($curso) {
                $q->where('nombre_curso', $curso);
            });
        }

        if ($materia) {
            $query->whereHas('materia', function($q) use ($materia) {
                $q->where('nombre_materia', $materia);
            });
        }

        if ($profesor) {
            $query->whereHas('profesor.persona', function($q) use ($profesor) {
                $q->whereRaw("CONCAT(nombres, ' ', apellidos) LIKE ?", ["%{$profesor}%"]); // Filtrar por nombre completo
            });
        }

        $clases = $query->get();

        // Verificar que hay datos antes de exportar
        if ($clases->isEmpty()) {
            return response()->json(['message' => 'No hay clases disponibles para exportar'], 404);
        }
       
        try{

            // Usar la exportación de Excel con los datos filtrados
            return Excel::download(new ClasesExport($clases), 'reporte_clases.xlsx');


        }catch (\Throwable $e) {
            // Captura cualquier excepción que se genere y loguéala o devuélvela para depuración
            return response()->json([
                'error' => 'Se produjo un error al generar el reporte',
                'mensaje' => $e->getMessage(),
                'linea' => $e->getLine(),
                'archivo' => $e->getFile(),
            ], 500);
        }
        
   } 

}
