<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class CursoController extends Controller
{

    public function index()
    {
        $curso = Curso::all();
        return response()-> json($curso,200);
    }

    
    public function store(Request $request)
    {
        $curso = Curso::create($request->all());
        return response()->json($curso, 201);

    }


    public function show(string $id)
    {
        $curso = Curso::find($id);
        return response()->json($curso,200);
    }


    public function update(Request $request, string $id)
    {
        $curso = Curso::findOrFail($id);
        
        $curso->update([
            'nombre_curso' => $request['nombre_curso'],
            'descripcion' => $request['descripcion'],
        ]);

        return response()->json($curso,200);

    }

    public function destroy(string $id)
    {
        Curso::find($id)->delete;
        return response()->json([
            'success'=> true
        ],200);

    }
}
