<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;

class MateriaController extends Controller
{
    public function index()
    {
        $materia = Materia::all();
        return response()-> json($materia,200);
    }


    public function store(Request $request)
    {
        $materia = Materia::create($request->all());
        return response()->json($materia, 201);
    }


    public function show(string $id)
    {
        $materia = Materia::find($id);
        return response()->json($materia,200);
    }


    public function update(Request $request, string $id)
    {
        $materia = Materia::findOrFail($id);
        
        $materia->update([
            'nombre_materia' => $request['nombre_materia'],
            'descripcion' => $request['descripcion'],
        ]);

        return response()->json($materia,200);
    }


    public function destroy(string $id)
    {
        Materia::find($id)->delete;

        return response()->json([
            'success'=> true
        ],200);
    }
}
