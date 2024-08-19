<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periodo;

class PeriodoController extends Controller
{
    public function index()
    {
        $periodo = Periodo::all();
        return response()-> json($periodo,200);
    }


    public function store(Request $request)
    {
        $periodo = Periodo::create($request->all());
        return response()->json($periodo, 201);
    }


    public function show(string $id)
    {
        $periodo = Periodo::find($id);
        return response()->json($periodo,200);
    }

   
    public function update(Request $request, string $id)
    {
        $periodo = Periodo::findOrFail($id);
        
        $periodo->update([
            'periodo' => $request['periodo'],
            'estado' => $request['estado'],
            'fecha_inicio' => $request['fecha_inicio'],
            'fecha_fin' => $request['fecha_fin'],
        ]);

        return response()->json($periodo,200);
    }


    public function destroy(string $id)
    {
        Periodo::find($id)->delete;
        
        return response()->json([
            'success'=> true
        ],200);

    }
}
